<?php

namespace Database\Factories\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\User;
use Database\Factories\Configuration\TransportistaFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package\Encomienda>
 */
class EncomiendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->randomNumber(8, false),
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'transportista_id' => $this->faker->randomElement(Transportista::pluck('id')->toArray()),
            'vehiculo_id' => $this->faker->randomElement(Vehiculo::pluck('id')->toArray()),
            'customer_id' => $this->faker->randomElement(Customer::pluck('id')->toArray()),
            'sucursal_id' => $this->faker->randomElement(Sucursal::pluck('id')->toArray()),
            'customer_dest_id' => $this->faker->randomElement(Customer::pluck('id')->toArray()),
            'sucursal_dest_id' => $this->faker->randomElement(Sucursal::pluck('id')->toArray()),
            'cantidad' => 2,
            'monto' => $this->faker->randomFloat(2, 1, 1000),
            'estado_pago' => $this->faker->randomElement(['PAGADO', 'CONTRA ENTREGA']),
            'tipo_pago' => $this->faker->randomElement(['Efectivo', 'Transferencia', 'Tarjeta de crédito']),
            'tipo_comprobante' => $this->faker->randomElement(['Factura','Boleta','Ticket']),
            'doc_traslado' => $this->faker->randomNumber(8, false),
            'estado_encomienda' => $this->faker->randomElement(['REGISTRADO', 'ENVIADO', 'RECIBIDO', 'ENTREGADO','CANCELADO']),
            'pin' => $this->faker->randomNumber(3, false),
        ];
    }
}

