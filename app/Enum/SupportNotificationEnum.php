<?php

namespace App\Enum;

enum SupportNotificationEnum: string
{
    case ACCOUNT_CREATION = 'ACCOUNT CREATION';
    case ACCOUNT_UPDATE = 'ACCOUNT UPDATE';
    case REFEREE_UPDATE = 'REFEREE UPDATE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function view(): string
    {
        return match ($this) {
            self::ACCOUNT_CREATION,
            self::REFEREE_UPDATE, self::ACCOUNT_UPDATE => 'emails.supportNotification',
        };
    }

    public function subject(): string
    {
        return match ($this) {
            self::ACCOUNT_CREATION => 'A new account has been created.',
            self::REFEREE_UPDATE => 'A referee account has been updated.',
            self::ACCOUNT_UPDATE => 'An account information has been updated.',
        };
    }
}
