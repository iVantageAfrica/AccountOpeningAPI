<?php

namespace App\Models\Account;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $account_number
 * @property string|null $mother_maiden_name
 * @property string|null $phone_number
 * @property string|null $email_address
 * @property string $employment_status
 * @property string|null $employer
 * @property string|null $account_officer
 * @property string|null $marital_status
 * @property string|null $house_number
 * @property string|null $street
 * @property string|null $city
 * @property string|null $state
 * @property string|null $origin
 * @property string|null $lga
 * @property string|null $next_of_kin_name
 * @property string|null $next_of_kin_address
 * @property string|null $next_of_kin_phone_number
 * @property string|null $next_of_kin_relationship
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|IndividualAccountUpdate newModelQuery()
 * @method static Builder<static>|IndividualAccountUpdate newQuery()
 * @method static Builder<static>|IndividualAccountUpdate query()
 * @method static Builder<static>|IndividualAccountUpdate whereAccountNumber($value)
 * @method static Builder<static>|IndividualAccountUpdate whereAccountOfficer($value)
 * @method static Builder<static>|IndividualAccountUpdate whereCity($value)
 * @method static Builder<static>|IndividualAccountUpdate whereCreatedAt($value)
 * @method static Builder<static>|IndividualAccountUpdate whereEmailAddress($value)
 * @method static Builder<static>|IndividualAccountUpdate whereEmployer($value)
 * @method static Builder<static>|IndividualAccountUpdate whereEmploymentStatus($value)
 * @method static Builder<static>|IndividualAccountUpdate whereHouseNumber($value)
 * @method static Builder<static>|IndividualAccountUpdate whereId($value)
 * @method static Builder<static>|IndividualAccountUpdate whereLga($value)
 * @method static Builder<static>|IndividualAccountUpdate whereMaritalStatus($value)
 * @method static Builder<static>|IndividualAccountUpdate whereMotherMaidenName($value)
 * @method static Builder<static>|IndividualAccountUpdate whereNextOfKinAddress($value)
 * @method static Builder<static>|IndividualAccountUpdate whereNextOfKinName($value)
 * @method static Builder<static>|IndividualAccountUpdate whereNextOfKinPhoneNumber($value)
 * @method static Builder<static>|IndividualAccountUpdate whereNextOfKinRelationship($value)
 * @method static Builder<static>|IndividualAccountUpdate whereOrigin($value)
 * @method static Builder<static>|IndividualAccountUpdate wherePhoneNumber($value)
 * @method static Builder<static>|IndividualAccountUpdate whereState($value)
 * @method static Builder<static>|IndividualAccountUpdate whereStreet($value)
 * @method static Builder<static>|IndividualAccountUpdate whereUpdatedAt($value)
 * @mixin Eloquent
 */
class IndividualAccountUpdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_number', 'mother_maiden_name', 'phone_number', 'email_address', 'employment_status', 'employer', 'account_officer', 'marital_status',
        'house_number', 'street', 'city', 'state', 'origin', 'lga', 'next_of_kin_name', 'next_of_kin_address', 'next_of_kin_phone_number', 'next_of_kin_relationship',
    ];

    protected $appends = ['address'];

    public function getAddressAttribute(): string
    {
        return collect([
            $this->house_number, $this->street, $this->city, $this->state])
            ->filter()
            ->implode(', ');
    }

}
