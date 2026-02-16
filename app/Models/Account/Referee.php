<?php

namespace App\Models\Account;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $email_address
 * @property string|null $phone_number
 * @property string|null $mobile_number
 * @property string|null $account_number
 * @property string|null $account_name
 * @property string|null $bank_name
 * @property string|null $account_type
 * @property string|null $known_period
 * @property string|null $comment
 * @property string|null $signature
 * @property bool $is_submitted
 * @property Carbon|null $submitted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereIsSubmitted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereKnownPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Referee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email_address','phone_number', 'mobile_number', 'account_number', 'account_name','account_type', 'bank_name', 'signature',
        'known_period', 'comment', 'is_submitted', 'submitted_at',
];

    protected $casts = [
        'is_submitted' => 'boolean',
        'submitted_at' => 'datetime',
    ];
}
