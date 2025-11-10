<?php

namespace App\Services\Utility;

use App\Enum\OtpPurpose;
use App\Exceptions\CustomException;
use App\Helpers\EncryptionHelper;
use App\Jobs\OTPJobs;
use App\Models\Utility\Otp;
use App\Services\ThirdParty\BluSalt;
use App\Services\ThirdParty\ImperialMortgage;
use Carbon\Carbon;
use Nette\Schema\ValidationException;
use Random\RandomException;

class UtilityService
{
    /**
     * @throws CustomException
     * @throws RandomException
     */
    public static function verifyBvn(string $bvn): array
    {
        $result = [];
        $emailAddress = '';

        //Check Imperial Mortgage BVN verification
        $imperialVerification = ImperialMortgage::verifyBvn($bvn);
        if ($imperialVerification['statusCode'] === 200) {
            $emailAddress = $imperialVerification['data']['UserEmail'];
            $result = $imperialVerification;
        }
        //Check Blu salt BVN verification
        else {
            $result = BluSalt::verifyBvn($bvn);
            if ($result['statusCode'] === 200) {
                $emailAddress = $result['data']['UserEmail'];
            } else {
                throw new CustomException('Invalid BVN provided. Please try again.');
            }
        }

        //Generate OTP for BVN verification
        $code = generateRandomNumber(6);
        dispatch(new OTPJobs($code, $emailAddress, OtpPurpose::BVN_VALIDATION->value));
        return array_merge($result, ['verificationToken' => EncryptionHelper::secureString(['reference' => $emailAddress, 'code' => $code])]);
    }



    public static function verifyOtpCode(string $otpCode, string $reference, string $code): bool
    {
        if ($code !== $otpCode) {
            throw new ValidationException('Unauthorized OTP code.');
        }
        $otpRecord = Otp::whereCode($otpCode)->first();
        if (!$otpRecord || $otpRecord->email_address !== $reference) {
            throw new ValidationException(message: 'Invalid OTP code.');
        }
        if (!$otpRecord->status) {
            throw new ValidationException(message: 'OTP code already used. Kindly contact support.');
        }
        if (Carbon::parse($otpRecord->expires_at)->isPast()) {
            throw new ValidationException(message: 'OTP code expired. Kindly request for a new one.');
        }
        $otpRecord->update(['status' => false]);
        return true;
    }

    /**
     * @throws CustomException
     * @throws RandomException
     */
    public static function requestOTP(string $emailAddress, OtpPurpose $purpose): string
    {
        $existingOtp = OTP::whereEmailAddress($emailAddress)
            ->wherePurpose($purpose->value)
            ->where('expires_at', '>', now())
            ->orderByDesc('created_at')
            ->first();

        if ($existingOtp) {
            $minutesSinceSent = $existingOtp->created_at->diffInMinutes(now());
            $waitMinutes = round(3 - $minutesSinceSent);
            if ($waitMinutes > 0) {
                throw new CustomException("Kindly wait for another {$waitMinutes} minute(s) before requesting a new OTP.");
            }
        }
        $otpCode = generateRandomNumber(6);
        OTPJobs::dispatch($otpCode, $emailAddress, $purpose->value);
        return EncryptionHelper::secureString(['reference' => $emailAddress, 'code' => $otpCode]);
    }
}
