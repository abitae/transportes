<?php

namespace Database\Seeders;

use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Sucursal::factory()->create(
            [
                'name' => 'HUANCAYO 28 DE JULIO',
                'address' => 'JR 28 DE JULIO 439 HUANCAYO',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'LIMA VILLEGAS',
                'address' => 'CALLE JULIO VILLEGAS 122-124 LA VICTORIA LIMA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'LIMA OBREROS',
                'address' => 'JR OBREROS 125  A LA VICTORIA LIMA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'HUANCAVELICA UNIVERSITARIA',
                'address' => 'Av. Universitaria 1003 Huancavelica',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'JAUJA',
                'address' => 'JAUJA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'OROYA',
                'address' => 'Av. ALVERTO DIAS 1288- SANTA ROSA DE SACO OROYA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'HUANUCO',
                'address' => 'HUANUCO',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'PICHANAKI',
                'address' => 'PICHANAKI',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'AREQUIPA',
                'address' => 'AREQUIPA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'name' => 'TRUJILLO',
                'address' => 'TRUJILLO',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );

        $user = User::factory()->create([
            'name' => 'Abel Arana',
            'email' => 'abel.arana@hotmail.com',
            'sucursal_id' => 1,
            'isActive' => true,
            'password' => bcrypt('lobomalo123'),
        ]);
        User::factory()->create([
            'name' => 'usuario1',
            'email' => 'usuario1@hotmail.com',
            'sucursal_id' => 2,
            'isActive' => true,
            'password' => bcrypt('lobomalo123'),
        ]);
        $role = Role::create(['name' => 'Admin']);
        $arrayOfPermissionNames = [];
        array_push(
            $arrayOfPermissionNames,
            'Crear usuario',
            'Ver usuario',
            'Editar usuario',
            'Eliminar usuario'
        );
        array_push(
            $arrayOfPermissionNames,
            'Crear rol',
            'Ver rol',
            'Editar rol',
            'Eliminar rol'
        );
        //CM permisos
        array_push(
            $arrayOfPermissionNames,
            'CM Import',
        );
        array_push(
            $arrayOfPermissionNames,
            'CM Data',
        );
        array_push(
            $arrayOfPermissionNames,
            'Crear acuerdo',
            'Ver acuerdo',
            'Editar acuerdo',
            'Eliminar acuerdo'
        );
        //CM end
        //CRM permisos
        array_push(
            $arrayOfPermissionNames,
            'Crear negocio',
            'Ver negocio',
            'Editar negocio',
            'Eliminar negocio'
        );
        array_push(
            $arrayOfPermissionNames,
            'Crear cliente',
            'Ver cliente',
            'Editar cliente',
            'Eliminar cliente'
        );
        array_push(
            $arrayOfPermissionNames,
            'Crear contacto',
            'Ver contacto',
            'Editar contacto',
            'Eliminar contacto'
        );
        //CRM end
        //Almacenar permisos
        array_push(
            $arrayOfPermissionNames,
            'Crear producto',
            'Ver producto',
            'Editar producto',
            'Eliminar producto'
        );
        array_push(
            $arrayOfPermissionNames,
            'Crear marca',
            'Ver marca',
            'Editar marca',
            'Eliminar marca'
        );
        array_push(
            $arrayOfPermissionNames,
            'Crear categoria',
            'Ver categoria',
            'Editar categoria',
            'Eliminar categoria'
        );
        array_push(
            $arrayOfPermissionNames,
            'Crear linea',
            'Ver linea',
            'Editar linea',
            'Eliminar linea'
        );
        //Almacen permisos end
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });
        Permission::insert($permissions->toArray());
        $role->syncPermissions(Permission::all());
        Customer::factory(100)->create();

        Transportista::factory(10)->create();
        Vehiculo::factory(10)->create();

        Encomienda::factory(1000)->create();
        Paquete::factory(10000)->create();
    }
}
