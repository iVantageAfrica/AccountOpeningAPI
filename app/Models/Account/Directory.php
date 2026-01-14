<?php

namespace App\Models\Account;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $othername
 * @property string|null $email_address
 * @property string|null $phone_number
 * @property string|null $bvn
 * @property string|null $nin
 * @property string|null $signature
 * @property string|null $passport
 * @property string|null $valid_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereNin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereOthername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Directory whereValidId($value)
 * @mixin Eloquent
 */
class Directory extends Model
{
    use HasFactory;
    protected $fillable = [
        'lastname', 'firstname', 'othername', 'email_address', 'phone_number', 'bvn', 'nin', 'signature', 'passport', 'valid_id',
    ];
}
