<?php

namespace App\Services\Utility;

use App\Enum\AccountNotificationEnum;
use App\Enum\OtpPurpose;
use App\Enum\SupportNotificationEnum;
use App\Helpers\EncryptionHelper;
use App\Models\User;
use App\Models\Utility\Otp;
use App\Services\Account\SupportNotificationService;
use App\Services\ThirdParty\ImperialMortgage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;

class MessageService
{
    /**
     * @throws RandomException
     */
    public static function createOTPCode(string $code, string $emailAddress, string $purpose, ?string $reference = null, ?string $phoneNumber = null): void
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
            self::mailMessage($emailAddress, $purpose, $emailTemplates[$purpose], ['otpCode' => $code, 'userName' => extractNameFromEmail($emailAddress)]);
        }
    }

    public static function accountCreationMessage(array $data): void
    {
        $userData = User::whereBvn($data['bvn'])->firstOrFail();
        $data['firstname'] = $userData->firstname;
        $data['customerName'] = $userData->firstname.' '.$userData->lastname;
        $data['email'] = $userData->email;
        $emailAddress = empty($data['businessEmailAddress']) ? $userData->email : $data['businessEmailAddress'];
        self::mailMessage($emailAddress, 'Your Imperial Homes Mortgage Bank Account Has Been Successfully Opened', 'emails.accountCreation', $data);
    }

    public static function accountReferenceMessage(array $data): void
    {
        self::mailMessage($data['email'], 'Request to Provide Account Reference – Imperial Homes Mortgage Bank', 'emails.accountReference', $data);
    }

    public static function accountSignatoryDirectoryMessage(array $data): void
    {
        $subject = $data['type'] === 'signatory' ? 'Request for Verification of Account Signatories' : 'Account Director Confirmation Request';
        self::mailMessage($data['email'], $subject, 'emails.signatoryDirectory', $data);
    }

    public static function accountNotificationMessage(array $data): void
    {
        $view = AccountNotificationEnum::from($data['notificationType'])->view();
        $subject = AccountNotificationEnum::from($data['notificationType'])->subject();
        self::mailMessage($data['email'], $subject, $view, $data);
    }

    public static function supportNotificationMessage(array $data): void
    {
        $view = SupportNotificationEnum::from($data['notificationType'])->view();
        $subject = SupportNotificationEnum::from($data['notificationType'])->subject().' .ACC NO-'.$data['accountData']['account_number'];
        self::mailMessageWithAttachment(SupportNotificationService::getActiveEmails(), $subject, $view, $data, $data['attachments'] ?? []);
    }

    public static function portalReferenceNotification(array $data): void
    {
        $adminView = SupportNotificationEnum::from($data['notificationType'])->view();
        $adminSubject = SupportNotificationEnum::from($data['notificationType'])->subject();
        $accountHolderView = 'emails.refereeNotification';
        $accountHolderSubject = 'New Imperial Account Reference Submitted– Account Opening Requirement';
        if (! empty($data['refereeData']['account_holder_email']) && $data['refereeData']['account_holder_email'] !== 'undefined') {
            self::mailMessage($data['refereeData']['account_holder_email'], $accountHolderSubject, $accountHolderView, $data);
        }
        self::mailMessageWithAttachment(SupportNotificationService::getActiveEmails(), $adminSubject, $adminView, $data, $data['attachments'] ?? []);
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

    public static function mailMessageWithAttachment(string|array $emailAddresses, string $subject, string $viewName, array $data = [], array $attachments = []): void
    {
        $emails = is_array($emailAddresses) ? $emailAddresses : [$emailAddresses];
        if (empty($emails)) {
            return;
        }

        Mail::send(
            $viewName,
            $data,
            static function ($message) use ($emails, $subject, $attachments) {
                $message->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($emails)
                    ->subject($subject);
                foreach ($attachments as $attachment) {
                    $message->attachData(
                        $attachment['data'],
                        $attachment['name'],
                        ['mime' => $attachment['mime'] ?? 'application/pdf']
                    );
                }
            }
        );
    }
}
