<?php

namespace Database\Seeders;

use App\Models\Configuration\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
