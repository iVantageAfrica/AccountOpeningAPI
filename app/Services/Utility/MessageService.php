<?php

namespace App\Services\Utility;

use App\Enum\OtpPurpose;
use App\Models\Utility\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class MessageService
{
    public static function createOTPCode(string $code, string $emailAddress, string $purpose): void
    {
        Otp::create(
            [
                'email_address' => $emailAddress,
                'purpose' => $purpose,
                'code' => $code,
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
