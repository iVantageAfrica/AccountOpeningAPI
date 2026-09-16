<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static Builder<static>|SupportNotification newModelQuery()
 * @method static Builder<static>|SupportNotification newQuery()
 * @method static Builder<static>|SupportNotification query()
 * @method static Builder<static>|SupportNotification whereStatus($value)
 */
class SupportNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function scopeActive($query): Builder
    {
        return $query->where('status', 'Active');
    }
}
