<?php

namespace App\Models\Account;

use App\Models\User;
use App\Models\Utility\AccountType;
use App\Traits\DateScope;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $account_type_id
 * @property string|null $account_number
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read AccountType $accountType
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest whereAccountTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DebitCardRequest whereUserId($value)
 * @mixin Eloquent
 */
class DebitCardRequest extends Model
{
    use HasFactory;
    use DateScope;
    protected $fillable = [
        'user_id','account_type_id','account_number','status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accountType(): BelongsTo
    {
        return $this->belongsTo(AccountType::class);
    }

}
