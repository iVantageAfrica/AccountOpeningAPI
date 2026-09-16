<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class () extends Migration {
    public function up(): void
    {
        $permission = Permission::firstOrCreate([
            'name' => 'manage-support-notifications',
            'guard_name' => 'web',
        ]);

        $superAdminRole = Role::where('name', 'Super Admin')->where('guard_name', 'web')->first();
        if ($superAdminRole && !$superAdminRole->hasPermissionTo($permission)) {
            $superAdminRole->givePermissionTo($permission);
        }
    }

    public function down(): void
    {
        Permission::where('name', 'manage-support-notifications')
            ->where('guard_name', 'web')
            ->delete();
    }
};