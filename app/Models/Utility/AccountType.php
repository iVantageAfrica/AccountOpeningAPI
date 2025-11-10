<?php

namespace App\Models\Utility;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string|null $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class AccountType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'category', 'code',
    ];
}
