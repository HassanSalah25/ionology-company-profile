<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permiissions_names = [
            'index users',
            'edit users',
            'delete users',
            'create users',
            'destroy users',
            'index categories',
            'edit categories',
            'delete categories',
            'create categories',
            'destroy categories',
            'index blogs',
            'edit blogs',
            'delete blogs',
            'create blogs',
            'destroy blogs',
            'index company_infos',
            'edit company_infos',
            'delete company_infos',
            'create company_infos',
            'destroy company_infos',
            'index roles',
            'edit roles',
            'delete roles',
            'create roles',
            'destroy roles',
            'index leads',
            'edit leads',
            'delete leads',
            'create leads',
            'destroy leads',
            'index pages',
            'edit pages',
            'delete pages',
            'create pages',
            'destroy pages',
            'index portfolios',
            'edit portfolios',
            'delete portfolios',
            'create portfolios',
            'destroy portfolios',
            'index reviews',
            'edit reviews',
            'delete reviews',
            'create reviews',
            'destroy reviews',
            'index services',
            'edit services',
            'delete services',
            'create services',
            'destroy services',
            'index settings',
            'edit settings',
            'delete settings',
            'create settings',
            'destroy settings',
        ];

        // create permissions
        foreach ($permiissions_names as $permission){
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'super admin']);
        foreach ($permiissions_names as $permission){
            $role->givePermissionTo($permission);
        }

        // create demo users
        $user = \App\Models\User::find(1);
        $user->assignRole($role);

    }
}
