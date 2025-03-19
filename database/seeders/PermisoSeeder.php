<?php

namespace Database\Seeders;

use App\Models\Configuration\Sucursal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [];
        $routes = [
            'caja',
            'ruta',
        ];

        // Generate permissions based on routes
        foreach ($routes as $route) {
            $permissions[] = $route . '.view';
            $permissions[] = $route . '.create';
            $permissions[] = $route . '.edit';
            $permissions[] = $route . '.delete';
        }

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
        $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        Permission::create(['name' => 'super.admin', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());
        User::factory()->create([
            'name'        => 'Abel Arana',
            'email'       => 'abel.arana@hotmail.com',
            'sucursal_id' => 1,
            'isActive'    => true,
            'password'    => bcrypt('lobomalo123'),
        ])->assignRole('SuperAdmin');

        $role = Role::create(['name' => 'Administrador', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());
        User::factory()->create([
            'name'        => 'Administrador',
            'email'       => 'admin.h28@brayanbruhs.pe',
            'sucursal_id' => 1,
            'isActive'    => true,
            'password'    => bcrypt('password'),
        ])->assignRole('Administrador');

        User::factory()->create([
            'name'        => 'Administrador',
            'email'       => 'admin.villegas@brayanbruhs.pe',
            'sucursal_id' => 2,
            'isActive'    => true,
            'password'    => bcrypt('password'),
        ])->assignRole('Administrador');


    }
}
