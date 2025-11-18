<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $bvn
 * @property string|null $nin
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $middle_name
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $gender
 * @property string|null $date_of_birth
 * @property int|null $savings_account_id
 * @property int|null $current_account_id
 * @property int|null $corporate_account_id
 * @property int|null $pos_merchant_account_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCorporateAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePosMerchantAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSavingsAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin Eloquent
 */
class User extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'bvn', 'nin','firstname', 'lastname', 'middle_name','email','phone_number','address','gender','date_of_birth',
        'savings_account_id', 'current_account_id','corporate_account_id','pos_merchant_account_id',
    ];

    public function accountData(): array
    {
        return $this->only(['bvn', 'nin', 'firstname', 'lastname', 'middle_name', 'email','phone_number', 'address','gender', 'date_of_birth']);
    }
}
