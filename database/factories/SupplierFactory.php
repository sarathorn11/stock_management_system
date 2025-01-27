<?php

namespace Database\Factories;

use App\Models\supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = supplier::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'cperson' => $this->faker->name,
            'contact' => $this->faker->phoneNumber,
            // 'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
