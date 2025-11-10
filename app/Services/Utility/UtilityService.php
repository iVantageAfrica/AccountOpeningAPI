<?php

namespace App\Services\Utility;

use App\Enum\OtpPurpose;
use App\Exceptions\CustomException;
use App\Helpers\EncryptionHelper;
use App\Jobs\OTPJobs;
use App\Models\Utility\Otp;
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
        $userBvn = ImperialMortgage::verifyBvn($bvn);
        $emailAddress = '';
        if ($userBvn['statusCode'] === 200) {
            $emailAddress = $userBvn['data']['UserEmail'];
        }

        //Generate OTP for BVN verification
        $code = generateRandomNumber(6);
        dispatch(new OTPJobs($code, $emailAddress, OtpPurpose::BVN_VALIDATION->value));
        return array_merge($userBvn, ['verificationToken' => EncryptionHelper::secureString(['reference' => $emailAddress, 'code' => $code])]);
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
}
