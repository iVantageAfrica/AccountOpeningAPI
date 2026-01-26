<?php

namespace App\Services\Utility;

use App\Enum\OtpPurpose;
use App\Helpers\EncryptionHelper;
use App\Models\User;
use App\Models\Utility\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;

class MessageService
{
    /**
     * @throws RandomException
     */
    public static function createOTPCode(string $code, string $emailAddress, string $purpose, string $reference = null): void
    {
        Otp::create(
            [
                'email_address' => strtolower($emailAddress),
                'purpose' => $purpose,
                'code' => $code,
                'reference' => EncryptionHelper::secureString($reference),
                'expires_at' => Carbon::now()->addMinutes(5),
            ]
        );

        if ($purpose === OtpPurpose::BVN_VALIDATION->value) {
            self::mailMessage($emailAddress, $purpose, 'emails.bvnValidation', ['otpCode' => $code]);
        }
        if ($purpose === OtpPurpose::RESET_PASSWORD->value) {
            self::mailMessage($emailAddress, $purpose, 'emails.resetPassword', ['otpCode' => $code]);
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
        self::mailMessage($data['email'], 'Request for Account Reference Confirmation', 'emails.accountReference', $data);
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
