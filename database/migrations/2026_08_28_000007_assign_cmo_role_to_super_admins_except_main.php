<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

return new class () extends Migration {
    public function up(): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $cmoRole = Role::where('name', 'Customer Management Officer')->first();

        if (!$superAdminRole || !$cmoRole) {
            return;
        }

        $admins = DB::table('admins')->get();

        foreach ($admins as $admin) {
            $roleId = strtolower($admin->email) === 'superadmin@imperial.com'
                ? $superAdminRole->id
                : $cmoRole->id;


            DB::table('model_has_roles')
                ->where('model_type', Admin::class)
                ->where('model_id', $admin->id)
                ->delete();

            // Assign the correct role.
            DB::table('model_has_roles')->insert([
                'role_id' => $roleId,
                'model_type' => Admin::class,
                'model_id' => $admin->id,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('model_has_roles')
            ->where('model_type', Admin::class)
            ->delete();
    }
};
