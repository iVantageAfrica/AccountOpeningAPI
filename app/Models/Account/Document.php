<?php

namespace App\Models\Account;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $valid_id
 * @property string|null $signature
 * @property string|null $name
 * @property string|null $utility_bill
 * @property string|null $passport
 * @property string|null $account_number
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Document newModelQuery()
 * @method static Builder<static>|Document newQuery()
 * @method static Builder<static>|Document onlyTrashed()
 * @method static Builder<static>|Document query()
 * @method static Builder<static>|Document whereCreatedAt($value)
 * @method static Builder<static>|Document whereDeletedAt($value)
 * @method static Builder<static>|Document whereId($value)
 * @method static Builder<static>|Document whereName($value)
 * @method static Builder<static>|Document wherePassport($value)
 * @method static Builder<static>|Document whereSignature($value)
 * @method static Builder<static>|Document whereUpdatedAt($value)
 * @method static Builder<static>|Document whereUtilityBill($value)
 * @method static Builder<static>|Document whereValidId($value)
 * @method static Builder<static>|Document withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Document withoutTrashed()
 * @method static Builder<static>|Document whereAccountNumber($value)
 * @mixin Eloquent
 */
class Document extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'valid_id', 'signature', 'utility_bill', 'passport','name','account_number',
    ];

}
