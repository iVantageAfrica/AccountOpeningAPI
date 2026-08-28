<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string $email
 * @property string $password
 * @property bool $is_admin
 * @property bool $is_super_admin
 * @property bool $is_default_password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Admin newModelQuery()
 * @method static Builder<static>|Admin newQuery()
 * @method static Builder<static>|Admin query()
 * @method static Builder<static>|Admin whereCreatedAt($value)
 * @method static Builder<static>|Admin whereEmail($value)
 * @method static Builder<static>|Admin whereFirstname($value)
 * @method static Builder<static>|Admin whereId($value)
 * @method static Builder<static>|Admin whereIsAdmin($value)
 * @method static Builder<static>|Admin whereIsDefaultPassword($value)
 * @method static Builder<static>|Admin whereIsSuperAdmin($value)
 * @method static Builder<static>|Admin whereLastname($value)
 * @method static Builder<static>|Admin wherePassword($value)
 * @method static Builder<static>|Admin whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Admin extends Model
{
    use HasFactory;
    use HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'is_admin','is_super_admin', 'is_default_password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = [
        'role',
    ];

    public function getRoleAttribute(): ?string
    {
        return $this->getRoleNames()->first() ?? null;
    }

    protected $casts = [
        'is_admin' => 'boolean',
        'is_super_admin' => 'boolean',
        'is_default_password' => 'boolean',
    ];

    public function adminInformation(): array
    {
        return $this->only(['id','firstname', 'lastname', 'email', 'is_admin', 'is_super_admin', 'is_default_password']);
    }

    public function adminInformationWithRolesAndPermissions(): array
    {
        $info = $this->adminInformation();
        $info['role'] = $this->getRoleNames()->first() ?? null;
        $info['permissions'] = $this->getAllPermissions()->pluck('name')->toArray();
        return $info;
    }
}
