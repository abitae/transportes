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


        $permissions = [
            'caja.index',
            'config.sucursal',
            'config.vehiculo',
            'config.transportista',
            'config.user',
            'config.role',
            'config.company',
            'config.configuration',
            'package.customer',
            'package.register',
            'package.send',
            'package.receive',
            'package.deliver',
            'package.record',
            'package.home',
            'package.return',
            'package.maniesto',
            'message.frontend',
            'facturacion.ticket',
            'facturacion.invoice',
            'facturacion.despache',
            'facturacion.note',
            'facturacion.create-invoice',
            'facturacion.create-note'
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
        $role = Role::create(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());
        User::factory()->create([
            'name' => 'Abel Arana',
            'email' => 'abel.arana@hotmail.com',
            'sucursal_id' => 1,
            'isActive' => true,
            'password' => bcrypt('lobomalo123'),
        ])->assignRole('SuperAdmin');

        $role = Role::create(['name' => 'Administrador', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());
        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin.h28@brayanbruhs.pe',
            'sucursal_id' => 1,
            'isActive' => true,
            'password' => bcrypt('password'),
        ])->assignRole('Administrador');

        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin.villegas@brayanbruhs.pe',
            'sucursal_id' => 2,
            'isActive' => true,
            'password' => bcrypt('password'),
        ])->assignRole('Administrador');


    }
}
