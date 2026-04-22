<?php

namespace App\Models\Account;

use Eloquent;
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereAccountOfficer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereEmploymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereHouseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereLga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereMotherMaidenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereNextOfKinAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereNextOfKinName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereNextOfKinPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereNextOfKinRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|IndividualAccountUpdate whereUpdatedAt($value)
 * @mixin Eloquent
 */
class IndividualAccountUpdate extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_number', 'mother_maiden_name', 'phone_number', 'email_address', 'employment_status', 'employer', 'account_officer', 'marital_status',
        'house_number', 'street', 'city', 'state', 'origin', 'lga', 'next_of_kin_name', 'next_of_kin_address', 'next_of_kin_phone_number', 'next_of_kin_relationship',
    ];
}
