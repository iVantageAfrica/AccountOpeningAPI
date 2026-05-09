<?php

namespace App\Models\Account;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $account_type_id
 * @property string|null $title
 * @property string|null $account_number
 * @property string|null $mother_maiden_name
 * @property string|null $phone_number
 * @property string|null $employment_status
 * @property string|null $employer
 * @property string|null $employer_address
 * @property string|null $marital_status
 * @property string|null $origin
 * @property string|null $lga
 * @property string|null $address
 * @property string|null $next_of_kin_name
 * @property string|null $next_of_kin_address
 * @property string|null $next_of_kin_relationship
 * @property string|null $next_of_kin_phone_number
 * @property string|null $account_officer
 * @property int|null $document_id
 * @property Referee|null $referees
 * @property string|null $referrer
 * @property string|null $occupation
 * @property bool $debit_card
 * @property string|null $status
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Document|null $document
 * @property-read User $user
 * @method static Builder<static>|IndividualAccount newModelQuery()
 * @method static Builder<static>|IndividualAccount newQuery()
 * @method static Builder<static>|IndividualAccount onlyTrashed()
 * @method static Builder<static>|IndividualAccount query()
 * @method static Builder<static>|IndividualAccount whereAccountNumber($value)
 * @method static Builder<static>|IndividualAccount whereAccountTypeId($value)
 * @method static Builder<static>|IndividualAccount whereAddress($value)
 * @method static Builder<static>|IndividualAccount whereCreatedAt($value)
 * @method static Builder<static>|IndividualAccount whereDebitCard($value)
 * @method static Builder<static>|IndividualAccount whereDeletedAt($value)
 * @method static Builder<static>|IndividualAccount whereDocumentId($value)
 * @method static Builder<static>|IndividualAccount whereEmployer($value)
 * @method static Builder<static>|IndividualAccount whereEmployerAddress($value)
 * @method static Builder<static>|IndividualAccount whereAccountOfficer($value)
 * @method static Builder<static>|IndividualAccount whereEmploymentStatus($value)
 * @method static Builder<static>|IndividualAccount whereId($value)
 * @method static Builder<static>|IndividualAccount whereMaritalStatus($value)
 * @method static Builder<static>|IndividualAccount whereOrigin($value)
 * @method static Builder<static>|IndividualAccount whereLga($value)
 * @method static Builder<static>|IndividualAccount whereMotherMaidenName($value)
 * @method static Builder<static>|IndividualAccount whereNextOfKinAddress($value)
 * @method static Builder<static>|IndividualAccount whereNextOfKinName($value)
 * @method static Builder<static>|IndividualAccount whereNextOfKinPhoneNumber($value)
 * @method static Builder<static>|IndividualAccount whereNextOfKinRelationship($value)
 * @method static Builder<static>|IndividualAccount whereOccupation($value)
 * @method static Builder<static>|IndividualAccount wherePhoneNumber($value)
 * @method static Builder<static>|IndividualAccount whereReferees($value)
 * @method static Builder<static>|IndividualAccount whereReferrer($value)
 * @method static Builder<static>|IndividualAccount whereStatus($value)
 * @method static Builder<static>|IndividualAccount whereTitle($value)
 * @method static Builder<static>|IndividualAccount whereUpdatedAt($value)
 * @method static Builder<static>|IndividualAccount whereUserId($value)
 * @method static Builder<static>|IndividualAccount withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|IndividualAccount withoutTrashed()
 * @mixin Eloquent
 */
class IndividualAccount extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'account_type_id','account_number','mother_maiden_name','phone_number','employment_status','employer_address', 'employer',
        'title', 'marital_status', 'address', 'next_of_kin_name','next_of_kin_address','next_of_kin_relationship','origin','lga',
        'next_of_kin_phone_number', 'document_id', 'referees','debit_card','status','referrer', 'occupation','account_officer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document(): HasMany
    {
        return $this->hasMany(Document::class, 'account_number', 'account_number');
    }

    public function accountUpdates(): HasMany
    {
        return $this->hasMany(IndividualAccountUpdate::class, 'account_number', 'account_number');
    }

    protected $casts = [
        'referees' => 'array',
        'debit_card' => 'boolean',
    ];

    public function getAccountTypeNameAttribute(): string
    {
        return match($this->account_type_id) {
            1 => 'Current Account',
            2 => 'Savings Account',
            3 => 'Corporate Account',
            4 => 'POS Merchant Account',
            default => 'Savings',
        };
    }
}
