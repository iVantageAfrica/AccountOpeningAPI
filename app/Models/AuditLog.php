<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $admin_id
 * @property string $action
 * @property string|null $description
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property array|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Admin|null $admin
 * @mixin Eloquent
 */
class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'action', 'description', 'ip_address', 'user_agent', 'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
