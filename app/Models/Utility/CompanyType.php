<?php

namespace App\Models\Utility;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CompanyType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
}
