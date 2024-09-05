<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'proyecto']);
        Permission::create(['name' => 'personal']);
        Permission::create(['name' => 'activos']);
        Permission::create(['name' => 'recursos']);
        Permission::create(['name' => 'actividades']);
        Permission::create(['name' => 'reporte']);
        Permission::create(['name' => 'checklist']);
        Permission::create(['name' => 'usuarios']);
        Permission::create(['name' => 'roles']);

        $adminRole = Role::create(['name' => 'administrador']);
        // $userRole = Role::create(['name' => 'usuario']);

        $adminRole->givePermissionTo('proyecto');
        $adminRole->givePermissionTo('personal');
        $adminRole->givePermissionTo('activos');
        $adminRole->givePermissionTo('recursos');
        $adminRole->givePermissionTo('actividades');
        $adminRole->givePermissionTo('reporte');
        $adminRole->givePermissionTo('checklist');
        $adminRole->givePermissionTo('usuarios');
        $adminRole->givePermissionTo('roles');

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('administrador');
    }
}
