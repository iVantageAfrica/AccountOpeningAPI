<?php

namespace App\Services\Utility;

use App\Enum\OtpPurpose;
use App\Helpers\EncryptionHelper;
use App\Models\User;
use App\Models\Utility\Otp;
use App\Services\ThirdParty\ImperialMortgage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;

class MessageService
{
    /**
     * @throws RandomException
     */
    public static function createOTPCode(string $code, string $emailAddress, string $purpose, string $reference = null, string $phoneNumber = null): void
    {
        Otp::create(
            [
                'email_address' => strtolower($emailAddress),
                'purpose' => $purpose,
                'phone_number' => $phoneNumber,
                'code' => $code,
                'reference' => EncryptionHelper::secureString($reference),
                'expires_at' => Carbon::now()->addMinutes(5),
            ]
        );
        $message = match ($purpose) {
            OtpPurpose::BVN_VALIDATION->value => "Your OTP code for BVN verification is: {$code}. This code is valid for 5 minutes. Do not share it with anyone.",
            OtpPurpose::RESET_PASSWORD->value => "You requested to reset your password. Your OTP code is: {$code}. This code is valid for 5 minutes. Do not share it with anyone.",
            default => "Your OTP code is: {$code}. This code is valid for 10 minutes. Do not share it with anyone.",
        };

        if ($phoneNumber) {
            ImperialMortgage::sendSmsToUser($phoneNumber, $message);
        }

        $emailTemplates = [
            OtpPurpose::BVN_VALIDATION->value => 'emails.bvnValidation',
            OtpPurpose::RESET_PASSWORD->value => 'emails.resetPassword',
        ];
        if (isset($emailTemplates[$purpose])) {
            self::mailMessage($emailAddress, $purpose, $emailTemplates[$purpose], ['otpCode' => $code]);
        }
    }

    public static function accountCreationMessage(array $data): void
    {
        $userData = User::whereBvn($data['bvn'])->firstOrFail();
        $data['firstname'] = $userData->firstname;
        $data['customerName'] = $userData->firstname.' '.$userData->lastname;
        $data['email'] = $userData->email;
        $emailView = $data['accountTypeId'] === 2 ? 'emails.savingsAccountCreation' : 'emails.CurrentAccountCreation';
        self::mailMessage($userData->email, 'Your Imperial Homes Mortgage Bank Account Has Been Successfully Opened', 'emails.accountCreation', $data);
    }

    public static function accountReferenceMessage(array $data): void
    {
        self::mailMessage($data['email'], 'Request to Provide Account Reference – Imperial Homes Mortgage Bank', 'emails.accountReference', $data);
    }

    public static function accountSignatoryDirectoryMessage(array $data): void
    {
        $subject = $data['type'] === 'signatory' ? 'Request for Verification of Account Signatories' : 'Account Directory Confirmation Request';
        self::mailMessage($data['email'], $subject, 'emails.signatoryDirectory', $data);
    }

    public static function mailMessage(string $emailAddress, string $subject, string $viewName, array $data = []): void
    {
        Mail::send(
            $viewName,
            $data,
            static function ($message) use ($emailAddress, $subject) {
                $message->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($emailAddress)
                    ->subject($subject);
            }
        );
    }

}
