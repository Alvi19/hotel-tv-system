<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            'dashboard' => ['view'],
            'roles' => ['view', 'create', 'edit', 'delete'],
            'users' => ['view', 'create', 'edit', 'delete'],
            'hotels' => ['view', 'create', 'edit', 'delete'],
            'rooms' => ['view', 'create', 'edit', 'delete', 'checkin', 'checkout'],
            'categories' => ['view', 'create', 'edit', 'delete'],
            'banners' => ['view', 'create', 'edit', 'delete'],
            'devices' => ['view', 'create', 'edit', 'delete'],
            'shortcuts' => ['view', 'create', 'edit', 'delete'],
        ];

        foreach ($modules as $module => $actions) {
            Permission::updateOrCreate(
                ['module' => $module],
                ['actions' => implode(',', $actions)]
            );
        }
    }

    // public function run()
    // {
    //     // 🔹 Daftar modul & action matrix (1 baris = 1 module)
    //     $modules = [
    //         'dashboard' => ['view'],
    //         'rooms' => ['view', 'create', 'edit', 'delete', 'checkin', 'checkout'],
    //         'banners' => ['view', 'create', 'edit', 'delete'],
    //         'users' => ['view', 'create', 'edit', 'delete'],
    //         'roles' => ['view', 'create', 'edit', 'delete'],
    //     ];

    //     // 🔹 Insert or update permissions
    //     foreach ($modules as $module => $actions) {
    //         Permission::updateOrCreate(
    //             ['module' => $module],
    //             [
    //                 'actions' => implode(',', $actions),
    //                 'description' => ucfirst($module) . ' management',
    //             ]
    //         );
    //     }

    //     // 🔹 Buat Super Admin (it_admin)
    //     $itAdminRole = Role::firstOrCreate(
    //         ['name' => 'it_admin'],
    //         [
    //             'display_name' => 'Super Admin',
    //             'scope' => 'global',
    //             'hotel_id' => null,
    //             'created_by' => null,
    //         ]
    //     );

    //     // 🔹 Assign semua permission ke Super Admin
    //     $permissions = Permission::all();
    //     $syncData = [];

    //     foreach ($permissions as $perm) {
    //         $syncData[$perm->id] = ['actions' => $perm->actions];
    //     }

    //     $itAdminRole->permissions()->sync($syncData);

    //     // 🔹 Opsional: assign super admin ke user pertama (hanya dev)
    //     if (app()->environment() !== 'production') {
    //         $user = User::first();
    //         if ($user) {
    //             $user->role_id = $itAdminRole->id;
    //             $user->save();
    //             $this->command->info('✅ Assigned Super Admin role to first user: ' . $user->name);
    //         }
    //     }

    //     $this->command->info('✅ Permission matrix seeding completed successfully!');
    // }
}
