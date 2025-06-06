<?php

namespace Database\Factories;

use App\Enums\WarehouseType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => 1,
            'type' => fake()->randomElement(WarehouseType::cases()),
            'code' => fake()->unique()->numerify('W-####'),
            'name' => fake()->unique()->city(),
            'location' => fake()->optional()->address(),
            'active' => fake()->boolean(),
        ];
    }
}
