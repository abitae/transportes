<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
