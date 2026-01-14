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
 * @property string|null $bvn
 * @property string|null $nin
 * @property string|null $signature
 * @property string|null $passport
 * @property string|null $proof_of_address
 * @property string|null $specimen_signature
 * @property string|null $partnership_deed
 * @property string|null $mode_of_operation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $joint_mandate
 * @property string|null $board_approve
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereBoardApprove($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereJointMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereModeOfOperation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereNin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory wherePartnershipDeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereProofOfAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereSpecimenSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Signatory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Signatory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'email_address', 'phone_number', 'bvn', 'nin', 'signature', 'passport', 'proof_of_address', 'specimen_signature',
        'partnership_deed', 'mode_of_operation', 'joint_mandate','board_approve',
    ];
}
