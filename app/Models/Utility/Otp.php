<?php

namespace App\Models\Utility;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $code
 * @property string $purpose
 * @property string $reference
 * @property string $email_address
 * @property string|null $phone_number
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $expires_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Otp whereExpiresAt($value)
 * @mixin Eloquent
 */
class Otp extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'status', 'expires_at','purpose','email_address','reference','phone_number',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
