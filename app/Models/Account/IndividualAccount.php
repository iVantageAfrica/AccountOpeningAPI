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
 * @property string|null $address
 * @property string|null $next_of_kin_name
 * @property string|null $next_of_kin_address
 * @property string|null $next_of_kin_relationship
 * @property string|null $next_of_kin_phone_number
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereDebitCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereEmployerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereEmploymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereMotherMaidenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereNextOfKinAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereNextOfKinName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereNextOfKinPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereNextOfKinRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereReferees($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereReferrer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccount withoutTrashed()
 * @mixin Eloquent
 */
class IndividualAccount extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'account_type_id','account_number','mother_maiden_name','phone_number','employment_status','employer_address', 'employer',
        'title', 'marital_status', 'address', 'next_of_kin_name','next_of_kin_address','next_of_kin_relationship',
        'next_of_kin_phone_number', 'document_id', 'referees','debit_card','status','referrer', 'occupation',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    protected $casts = [
        'referees' => 'array',
        'debit_card' => 'boolean',
    ];
}
