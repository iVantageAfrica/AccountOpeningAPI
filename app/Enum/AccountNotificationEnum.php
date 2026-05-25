<?php

namespace App\Enum;

enum AccountNotificationEnum: string
{
    case ACCOUNT_UPDATE = 'ACCOUNT UPDATE';
    case DOCUMENT_UPDATE = 'DOCUMENT UPDATE';
    case DOCUMENT_SUBMISSION = 'DOCUMENT SUBMISSION';
    case BANK_ACCOUNT_REFEREE_UPDATE = 'BANK ACCOUNT REFEREE UPDATE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function view(): string
    {
        return match ($this) {
            self::ACCOUNT_UPDATE => 'emails.accountUpdate',
            self::DOCUMENT_UPDATE => 'emails.documentUpdate',
            self::BANK_ACCOUNT_REFEREE_UPDATE => 'emails.bankAccountReferenceUpdate',

        };
    }

    public function subject(): string
    {
        return match ($this) {
            self::ACCOUNT_UPDATE => 'Request to Update Your Imperial Homes Account Information',
            self::DOCUMENT_UPDATE => 'Request to Submit Your Imperial Homes Account Supporting Documents',
            self::BANK_ACCOUNT_REFEREE_UPDATE => 'Request to Provide Your Imperial Homes Account Reference Information',
        };
    }

}
