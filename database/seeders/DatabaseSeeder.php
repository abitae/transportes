<?php

namespace Database\Seeders;

use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use App\Models\User;
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
        Company::factory()->create(
            [
                'ruc' => '20568031734',
                'razonSocial' => 'CORPORACIÓN LOGÍSTICO BRAYAN BRUHS EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA',
                'nombreComercial' => 'CORPORACIÓN LOGÍSTICO BRAYAN BRUHS EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA',
                'address' => 'PJ. LOS PEDREGALES MZA. D LOTE. 4 GRU.SECTOR 3 LOS PEDREGAL   JUNíN -  HUANCAYO  -  EL TAMBO',
                'email' => 'abel.arana@gmail.com',
                'telephone' => '947199138',
                'logo_path' => 'company/logo/sq2vGUegnQe99UcdIXABpm8c6cmMWfwKl0saNmFm.png',
                'sol_user' => 'MODDATOS',
                'sol_pass' => 'MODDATOS',
                'cert_path' => 'company/certificado/3EsIYvCPxwbRaA5z1r7j7v4El9sBLya80slxwHjX',
                'client_id' => 'test-85e5b0ae-255c-4891-a595-0b98c65c9854',
                'client_secret' => 'test-Hty/M6QshYvPgItX2P0+Kw==',
                'production' => false,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'H28',
                'name' => 'HUANCAYO 28 DE JULIO',
                'address' => 'JR 28 DE JULIO 439 HUANCAYO',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'LVI',
                'name' => 'LIMA VILLEGAS',
                'address' => 'CALLE JULIO VILLEGAS 122-124 LA VICTORIA LIMA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'LOB',
                'name' => 'LIMA OBREROS',
                'address' => 'JR OBREROS 125  A LA VICTORIA LIMA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'HVU',
                'name' => 'HUANCAVELICA UNIVERSITARIA',
                'address' => 'Av. Universitaria 1003 Huancavelica',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'JAU',
                'name' => 'JAUJA',
                'address' => 'JAUJA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'ORO',
                'name' => 'OROYA',
                'address' => 'Av. ALVERTO DIAS 1288- SANTA ROSA DE SACO OROYA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'HUA',
                'name' => 'HUANUCO',
                'address' => 'HUANUCO',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'PIC',
                'name' => 'PICHANAKI',
                'address' => 'PICHANAKI',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'ARQ',
                'name' => 'AREQUIPA',
                'address' => 'AREQUIPA',
                'phone' => '1234567890',
                'email' => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]
        );
        Sucursal::factory()->create(
            [
                'code' => 'TRU',
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

        //Encomienda::factory(1000)->create();
        //Paquete::factory(10000)->create();
    }
}
