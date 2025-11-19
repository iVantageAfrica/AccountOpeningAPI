<?php

namespace App\Models\Account;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $user_id
 * @property int $account_type_id
 * @property string|null $account_number
 * @property string|null $company_name
 * @property string|null $registration_number
 * @property string|null $company_type
 * @property string|null $tin
 * @property string|null $address
 * @property string|null $phone_number
 * @property string|null $business_email
 * @property string|null $city
 * @property string|null $lga
 * @property string|null $state
 * @property string|null $account_officer
 * @property string|null $cac
 * @property array<array-key, mixed>|null $signatories
 * @property array<array-key, mixed>|null $directors
 * @property array<array-key, mixed>|null $referees
 * @property bool $debit_card
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereAccountOfficer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereBusinessEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereCac($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereCompanyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereDebitCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereDirectors($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereLga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereReferees($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereSignatories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CorporateAccount withoutTrashed()
 * @mixin Eloquent
 */
class CorporateAccount extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'account_type_id','account_number', 'company_name','registration_number','company_type','tin',
        'address','phone_number','business_email','city', 'lga','state','account_officer','cac','signatories','referees',
        'debit_card','directors',
    ];

    protected $casts = [
        'referees' => 'array',
        'signatories' => 'array',
        'directors' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
