<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models\Account{
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
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
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
     */
    class IndividualAccountUpdate extends \Eloquent
    {
    }
}
