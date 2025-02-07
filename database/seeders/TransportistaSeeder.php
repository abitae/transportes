<?php

namespace Database\Seeders;

use App\Models\Configuration\Transportista;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transportista::factory()->count(10)->create();
    }
}
