<?php

namespace App\Models\Account;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $bvn
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Director whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Director extends Model
{
    use HasFactory;
    protected $fillable = [
         'lastname', 'firstname', 'bvn',
    ];
}
