<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        Permission::truncate();
        Role::truncate();

        $dashboardPermissions = [
            'view-dashboard',
            'view-customer-list',
            'view-account-lists',
            'view-account-details',
            'send-account-update-link',
            'view-portal-references',
            'view-debit-card-requests',
        ];

        $cmoPermissions = [
            'review-account',
            'flag-account',
        ];

        $compliancePermissions = [
            'approve-account',
            'flag-account-for-compliance',
        ];

        $adminManagementPermissions = [
            'manage-admins',
            'assign-roles',
        ];

        $allPermissions = array_merge(
            $dashboardPermissions,
            $cmoPermissions,
            $compliancePermissions,
            $adminManagementPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo($allPermissions);

        $cmo = Role::create(['name' => 'Customer Management Officer', 'guard_name' => 'web']);
        $cmo->givePermissionTo(array_merge($dashboardPermissions, $cmoPermissions));

        $compliance = Role::create(['name' => 'Compliance Officer', 'guard_name' => 'web']);
        $compliance->givePermissionTo(array_merge($dashboardPermissions, $compliancePermissions));

        $superAdminUser = Admin::where('email', 'superadmin@imperial.com')->first();
        if ($superAdminUser) {
            $superAdminUser->assignRole($superAdmin);
        }
    }
}
