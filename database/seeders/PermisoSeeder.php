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
            'caja.view', 'caja.create', 'caja.edit', 'caja.delete',
            'config_sucursal.view', 'config_sucursal.create', 'config_sucursal.edit', 'config_sucursal.delete',
            'registrar_paquetes.view', 'registrar_paquetes.create', 'registrar_paquetes.edit', 'registrar_paquetes.delete',
            'enviar_paquetes.view', 'enviar_paquetes.create', 'enviar_paquetes.edit', 'enviar_paquetes.delete',
            'recibir_paquetes.view', 'recibir_paquetes.create', 'recibir_paquetes.edit', 'recibir_paquetes.delete',
            'entregar_paquetes.view', 'entregar_paquetes.create', 'entregar_paquetes.edit', 'entregar_paquetes.delete',
            'paquetes_domicilio.view', 'paquetes_domicilio.create', 'paquetes_domicilio.edit', 'paquetes_domicilio.delete',
            'paquetes_retorno.view', 'paquetes_retorno.create', 'paquetes_retorno.edit', 'paquetes_retorno.delete',
            'historial_paquetes.view', 'historial_paquetes.create', 'historial_paquetes.edit', 'historial_paquetes.delete',
            'clientes.view', 'clientes.create', 'clientes.edit', 'clientes.delete',
            'manifiestos.view', 'manifiestos.create', 'manifiestos.edit', 'manifiestos.delete',
            'configuracion.view', 'configuracion.create', 'configuracion.edit', 'configuracion.delete',
            'mensajes.view', 'mensajes.create', 'mensajes.edit', 'mensajes.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }
        
        $role = Role::create(['name' => 'Administrador', 'guard_name' => 'web']);  
        $role->syncPermissions(Permission::all());
        User::factory()->create([
            'name'        => 'Administrador',
            'email'       => 'administrador@brayanbruhs.pe',
            'sucursal_id' => Sucursal::first()->id,
            'isActive'    => true,
            'password'    => bcrypt('password'),
        ])->assignRole('Administrador');
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
        
    }
}
