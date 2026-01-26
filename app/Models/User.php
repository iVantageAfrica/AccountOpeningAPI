<?php

namespace App\Models;

use App\Models\Account\IndividualAccount;
use App\Traits\DateScope;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read IndividualAccount|null $currentAccount
 * @property-read IndividualAccount|null $savingsAccount
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User lastMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User lastWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User thisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User thisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User today()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User yesterday()
 * @mixin Eloquent
 */
class User extends Model
{
    use HasFactory;
    use SoftDeletes;
    use DateScope;
    protected $fillable = [
        'bvn', 'nin','firstname', 'lastname', 'middle_name','email','phone_number','address','gender','date_of_birth',
    ];

    public function accountData(): array
    {
        return $this->only(['bvn', 'nin', 'firstname', 'lastname', 'middle_name', 'email','phone_number', 'address','gender', 'date_of_birth']);
    }

    public function savingsAccount(): HasOne
    {
        return $this->hasOne(IndividualAccount::class)->where('account_type_id', 2);
    }

    public function currentAccount(): HasOne
    {
        return $this->hasOne(IndividualAccount::class)->where('account_type_id', 1);
    }

    public function getUsernameAttribute(): string
    {
        return Str::lower(
            Str::slug($this->firstname . ' ' . $this->lastname, '.')
        );
    }
}
