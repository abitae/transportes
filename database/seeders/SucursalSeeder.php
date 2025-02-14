<?php

namespace Database\Seeders;

use App\Models\Configuration\Sucursal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursales = [
            ['code' => 'H28','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'HUANCAYO 28 DE JULIO', 'address' => 'JR 28 DE JULIO 439 HUANCAYO'],
            ['code' => 'LVI','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'LIMA VILLEGAS', 'address' => 'CALLE JULIO VILLEGAS 122-124 LA VICTORIA LIMA'],
            ['code' => 'LOB','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'LIMA OBREROS', 'address' => 'JR OBREROS 125  A LA VICTORIA LIMA'],
            ['code' => 'HVU','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'HUANCAVELICA UNIVERSITARIA', 'address' => 'Av. Universitaria 1003 Huancavelica'],
            ['code' => 'JAU','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'JAUJA', 'address' => 'JAUJA'],
            ['code' => 'ORO','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'OROYA', 'address' => 'Av. ALVERTO DIAS 1288- SANTA ROSA DE SACO OROYA'],
            ['code' => 'HUA','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'HUANUCO', 'address' => 'HUANUCO'],
            ['code' => 'PIC','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'PICHANAKI', 'address' => 'PICHANAKI'],
            ['code' => 'ARQ','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'AREQUIPA', 'address' => 'AREQUIPA'],
            ['code' => 'TRU','codeSunat'=>'0000','igv'=>18, 'serieFactura' => 'F001', 'serieBoleta' => 'B001', 'serieGuiaRemision' => 'V001', 'serieNotaCreditoFactura' => 'FC01', 'serieNotaCreditoBoleta' => 'BC01', 'serieNotaDebitoFactura' => 'FD01', 'serieNotaDebitoBoleta' => 'BD01', 'color' => '#8fe6d4', 'name' => 'TRUJILLO', 'address' => 'TRUJILLO'],
        ];

        foreach ($sucursales as $sucursal) {
            Sucursal::factory()->create(array_merge($sucursal, [
                'phone'    => '1234567890',
                'email'    => 'sucursal1@hotmail.com',
                'isActive' => true,
            ]));
        }
    }
}
