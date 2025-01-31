<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(), // Generates a random company name
            'address' => $this->faker->address(), // Generates a random address
            'cperson' => $this->faker->name(), // Generates a random contact person name
            'contact' => $this->faker->phoneNumber(), // Generates a random phone number
            // 'status' => $this->faker->numberBetween(0, 1), // Random status (0 or 1)
        ];
    }
}
