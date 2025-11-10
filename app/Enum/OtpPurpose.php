<?php

namespace App\Enum;

enum OtpPurpose: string
{
    case BVN_VALIDATION = 'BVN VALIDATION';
    case RESET_PASSWORD = 'RESET PASSWORD';

    public static function getValues(): array
    {
        return array_map(static fn ($case) => $case->value, self::cases());
    }
}
