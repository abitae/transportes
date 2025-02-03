<?php
namespace Database\Seeders;

use App\Models\Configuration\Company;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
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
        $this->call([
            // Otros seeders
            SqlFileSeeder::class,
        ]);
        Company::factory()->create([
            'ruc'             => '20568031734',
            'razonSocial'     => 'CORPORACIÓN LOGÍSTICO BRAYAN BRUHS EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA',
            'nombreComercial' => 'CORPORACIÓN LOGÍSTICO BRAYAN BRUHS EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA',
            'address'         => 'PJ. LOS PEDREGALES MZA. D LOTE. 4 GRU.SECTOR 3 LOS PEDREGAL   JUNíN -  HUANCAYO  -  EL TAMBO',
            'email'           => 'abel.arana@gmail.com',
            'telephone'       => '947199138',
            'logo_path'       => 'company/logo/sq2vGUegnQe99UcdIXABpm8c6cmMWfwKl0saNmFm.png',
            'sol_user'        => 'MODDATOS',
            'sol_pass'        => 'MODDATOS',
            'cert_path'       => 'company/certificado/certificado_prueba.pem',
            'client_id'       => 'test-85e5b0ae-255c-4891-a595-0b98c65c9854',
            'client_secret'   => 'test-Hty/M6QshYvPgItX2P0+Kw==',
            'production'      => false,
        ]);

        $sucursales = [
            ['code' => 'H28', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'HUANCAYO 28 DE JULIO', 'address' => 'JR 28 DE JULIO 439 HUANCAYO'],
            ['code' => 'LVI', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'LIMA VILLEGAS', 'address' => 'CALLE JULIO VILLEGAS 122-124 LA VICTORIA LIMA'],
            ['code' => 'LOB', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'LIMA OBREROS', 'address' => 'JR OBREROS 125  A LA VICTORIA LIMA'],
            ['code' => 'HVU', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'HUANCAVELICA UNIVERSITARIA', 'address' => 'Av. Universitaria 1003 Huancavelica'],
            ['code' => 'JAU', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'JAUJA', 'address' => 'JAUJA'],
            ['code' => 'ORO', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'OROYA', 'address' => 'Av. ALVERTO DIAS 1288- SANTA ROSA DE SACO OROYA'],
            ['code' => 'HUA', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'HUANUCO', 'address' => 'HUANUCO'],
            ['code' => 'PIC', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'PICHANAKI', 'address' => 'PICHANAKI'],
            ['code' => 'ARQ', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'AREQUIPA', 'address' => 'AREQUIPA'],
            ['code' => 'TRU', 'serie' => 'F001', 'color' => '#8fe6d4', 'name' => 'TRUJILLO', 'address' => 'TRUJILLO'],
        ];

        foreach ($sucursales as $sucursal) {
            Sucursal::factory()->create(array_merge($sucursal, [
                'phone'    => '1234567890',
                'email'    => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]));
        }

        User::factory()->create([
            'name'        => 'Abel Arana',
            'email'       => 'abel.arana@hotmail.com',
            'sucursal_id' => 1,
            'isActive'    => true,
            'password'    => bcrypt('lobomalo123'),
        ]);

        User::factory()->create([
            'name'        => 'usuario1',
            'email'       => 'usuario1@hotmail.com',
            'sucursal_id' => 2,
            'isActive'    => true,
            'password'    => bcrypt('lobomalo123'),
        ]);

        $role        = Role::create(['name' => 'Admin']);
        $permissions = [
            'Crear usuario', 'Ver usuario', 'Editar usuario', 'Eliminar usuario',
            'Crear rol', 'Ver rol', 'Editar rol', 'Eliminar rol',
            'CM Import', 'CM Data', 'Crear acuerdo', 'Ver acuerdo', 'Editar acuerdo', 'Eliminar acuerdo',
            'Crear negocio', 'Ver negocio', 'Editar negocio', 'Eliminar negocio',
            'Crear cliente', 'Ver cliente', 'Editar cliente', 'Eliminar cliente',
            'Crear contacto', 'Ver contacto', 'Editar contacto', 'Eliminar contacto',
            'Crear producto', 'Ver producto', 'Editar producto', 'Eliminar producto',
            'Crear marca', 'Ver marca', 'Editar marca', 'Eliminar marca',
            'Crear categoria', 'Ver categoria', 'Editar categoria', 'Eliminar categoria',
            'Crear linea', 'Ver linea', 'Editar linea', 'Eliminar linea',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $role->syncPermissions(Permission::all());

        Customer::factory(100)->create();
        Transportista::factory(10)->create();
        Vehiculo::factory(10)->create();
        //Encomienda::factory(1000)->create();
        //Invoice::factory(100)->create();
        //InvoiceDetail::factory(10)->create();

        //Encomienda::factory(1000)->create();
        //Paquete::factory(10000)->create();

    }
}
