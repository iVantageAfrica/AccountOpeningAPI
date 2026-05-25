<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string $email
 * @property string $password
 * @property bool $is_admin
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
 * @method static Builder<static>|Admin whereLastname($value)
 * @method static Builder<static>|Admin wherePassword($value)
 * @method static Builder<static>|Admin whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'is_admin','is_super_admin',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_super_admin' => 'boolean',
    ];

    public function adminInformation(): array
    {
        return $this->only(['id','firstname', 'lastname', 'email', 'is_admin', 'is_super_admin']);
    }
}
