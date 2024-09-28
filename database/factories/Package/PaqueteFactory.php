<?php

namespace Database\Factories\Package;

use App\Models\Package\Encomienda;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package\Paquete>
 */
class PaqueteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'encomienda_id' => $this->faker->randomElement(Encomienda::pluck('id')->toArray()),
            'cantidad' => $this->faker->randomNumber(2, false),
            'description' => $this->faker->address,
            'peso' => 10.4,
            'amount' => 12.8,
            'sub_total' => 50.20,
        ];
    }
}
