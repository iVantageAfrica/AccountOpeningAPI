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
 * @property int|null $account_number
 * @property string|null $business_sector
 * @property string|null $business_name
 * @property string|null $phone_number
 * @property string|null $business_address
 * @property string|null $email_address
 * @property string|null $lga
 * @property string|null $city
 * @property string|null $state
 * @property string|null $cac
 * @property int|null $document_id
 * @property-read Document|null $document
 * @property-read User|null $user
 * @property bool $debit_card
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereBusinessAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereBusinessSector($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereCac($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereDebitCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereLga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MerchantAccount whereUserId($value)
 * @mixin Eloquent
 */
class MerchantAccount extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id' ,'account_type_id', 'account_number', 'business_sector','email_address', 'business_name', 'phone_number','business_address',
        'lga', 'city', 'state', 'cac', 'document_id', 'debit_card',
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
