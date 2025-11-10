<?php

namespace App\Enum;

use App\Models\Utility\AccountType;

enum ModelClassEnum: string
{
    case ACCOUNT_TYPE = AccountType::class;
}
