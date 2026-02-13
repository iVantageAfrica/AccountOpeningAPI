<?php

namespace App\Services\Account;

use App\Enum\OtpPurpose;
use App\Exceptions\CustomException;
use App\Helpers\EncryptionHelper;
use App\Jobs\OTPJobs;
use App\Models\User;
use App\Models\Utility\Otp;
use App\Services\ThirdParty\BluSalt;
use App\Services\ThirdParty\ImperialMortgage;
use Carbon\Carbon;
use Random\RandomException;

class VerificationService
{
    /**
     * @throws CustomException
     * @throws RandomException
     */
    public static function verifyBvn(string $bvn, string $accountTypeId): array
    {
        if (!preg_match('/^\d{11}$/', $bvn)) {
            throw new CustomException('BVN must be exactly 11 digits.', 400);
        }
        $result = self::bvnVerification($bvn, $accountTypeId);

        //Generate OTP for BVN verification
        $code = generateRandomNumber(6);
        dispatch(new OTPJobs($code, $result['UserEmail'], OtpPurpose::BVN_VALIDATION->value, $bvn, $result['UserPhoneNo']));
        return ['emailAddress' => $result['UserEmail'],
                'phoneNumber' => $result['UserPhoneNo'],
                'authToken' => EncryptionHelper::secureString(['reference' => $result['UserEmail'], 'code' => $code])];
    }


    /**
     * @throws CustomException
     * @throws RandomException
     */
    public static function verifyOtpCode(string $otpCode, string $reference, string $code): array
    {
        if ($code !== $otpCode) {
            throw new CustomException('Invalid OTP code.');
        }
        $otpRecord = Otp::whereCode($otpCode)->first();
        if (!$otpRecord || strcasecmp($otpRecord->email_address, $reference) !== 0) {
            throw new CustomException(message: 'Invalid OTP code.');
        }
        if (!$otpRecord->status) {
            throw new CustomException(message: 'OTP code already used. Kindly contact support.');
        }
        if (Carbon::parse($otpRecord->expires_at)->isPast()) {
            throw new CustomException(message: 'OTP code expired. Kindly request for a new one.');
        }

        $data = ($otpRecord->purpose === OtpPurpose::BVN_VALIDATION->value)
            ? User::whereBvn(EncryptionHelper::secureString($otpRecord->reference, 'decrypt'))->first()?->accountData()
            : [];
        $otpRecord->update(['status' => false]);
        return ['bvnData' => $data];
    }

    /**
     * @throws CustomException
     * @throws RandomException
     */
    public static function requestOTP(string $emailAddress, OtpPurpose $purpose): string
    {
        $reference = null;
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
            $reference = EncryptionHelper::secureString($existingOtp->reference, 'decrypt');
        }
        if ($purpose->value === OtpPurpose::BVN_VALIDATION->value) {
            $reference = EncryptionHelper::secureString(OTP::whereEmailAddress($emailAddress)
                ->wherePurpose(OtpPurpose::BVN_VALIDATION->value)
                ->latest()
                ->value('reference'), 'decrypt');
        }
        $otpCode = generateRandomNumber(6);
        OTPJobs::dispatch($otpCode, $emailAddress, $purpose->value, $reference);
        return EncryptionHelper::secureString(['reference' => $emailAddress, 'code' => $otpCode]);
    }


    /**
     * @throws CustomException
     */
    private static function bvnVerification(string $bvn, string $accountTypeId): array
    {
        //Manual check if user bvn already exist in the db
        $userBvnData = User::whereBvn($bvn)->first();
        if ($userBvnData) {
            $accountType = match ($accountTypeId) {
                '1', '2' => 'INDIVIDUAL',
                '3' => 'CORPORATE',
                default => 'MERCHANT',
            };
            AccountService::ensureAccountDoesNotExist($userBvnData->id, $accountTypeId, $accountType);
            return ['UserEmail' => $userBvnData->accountData()['email'],
                    'UserPhoneNo' => $userBvnData->accountData()['phone_number']];
        }

        //Consume provider if user bvn is not saved before
        $providers = [
            fn () => ImperialMortgage::verifyBvn($bvn),
            fn () => BluSalt::verifyBvn($bvn),
        ];
        foreach ($providers as $provider) {
            $response = $provider();
            if (($response['statusCode'] ?? null) === 200) {
                AccountService::accountCreation($response['data'], $bvn);
                return $response['data'];
            }
        }
        throw new CustomException('Invalid BVN provided. Please try again.', 404);
    }



}
