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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Referee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email_address','phone_number', 'mobile_number',
    ];
}
