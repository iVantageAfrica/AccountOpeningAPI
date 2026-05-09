<?php

namespace App\Enum;

enum SupportNotificationEnum: string
{
    case ACCOUNT_CREATION = 'ACCOUNT CREATION';
    case REFEREE_UPDATE = 'REFEREE UPDATE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function view(): string
    {
        return match ($this) {
            self::ACCOUNT_CREATION,
            self::REFEREE_UPDATE => 'emails.supportNotification',
        };
    }

    public function subject(): string
    {
        return match ($this) {
            self::ACCOUNT_CREATION => 'A new account has been created.',
            self::REFEREE_UPDATE => 'A referee account has been updated.',
        };
    }
}
