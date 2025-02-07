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
            EmpresaSeeder::class,
            SucursalSeeder::class,
            PermisoSeeder::class,
            TransportistaSeeder::class,
            VehiculoSeeder::class,
        ]);
    }
}
