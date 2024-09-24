<?php

namespace Database\Factories\Package;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_code' => $this->faker->randomElement(['dni', 'ruc']),
            'code' => $this->faker->randomNumber(8, false),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'isActive' => true,
        ];
    }
}
