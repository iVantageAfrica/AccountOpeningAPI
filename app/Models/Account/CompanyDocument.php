<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $cac
 * @property string|null $memart
 * @property string|null $cac_co2
 * @property string|null $cac_co7
 * @property string|null $board_resolution
 * @property string|null $partnership_resolution
 * @property string|null $declaration_form
 * @property string|null $proprietor_declaration
 * @property string|null $signatory_mandate
 * @property string|null $partnership_deed
 * @property string|null $tin
 * @property string|null $society_resolution
 * @property string|null $principal_list
 * @property string|null $constitution
 * @property string|null $trustee_list
 * @property string|null $trust_deed
 * @property string|null $trustee_resolution
 * @property string|null $nipc_certificate
 * @property string|null $business_permit
 * @property string|null $due_diligence
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereBoardResolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument wherePartnershipResolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereBusinessPermit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereCac($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereCacCo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereCacCo7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereConstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereDeclarationForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereDueDiligence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereMemart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereNipcCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument wherePartnershipDeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument wherePrincipalList($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereProprietorDeclaration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereSignatoryMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereSocietyResolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereTin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereTrustDeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereTrusteeList($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereTrusteeResolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanyDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'cac', 'memart', 'cac_co2', 'cac_co7', 'board_resolution', 'declaration_form','partnership_resolution', 'proprietor_declaration', 'signatory_mandate', 'partnership_deed',
        'tin', 'society_resolution', 'principal_list', 'constitution', 'trustee_list', 'trust_deed', 'trustee_resolution', 'nipc_certificate',
        'business_permit', 'due_diligence',
    ];
}
