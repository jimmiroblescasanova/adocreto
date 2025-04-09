<?php

namespace Database\Factories;

use App\Enums\EntityType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => fake()->randomElement([1, 2]),
            'type' => fake()->randomElement(EntityType::class),
            'name' => fake()->company(),
            'rfc' => fake()->optional()->regexify('[A-Z]{3}[0-9]{10}'),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'active' => fake()->boolean(),
            'notes' => fake()->optional()->text(),
        ];
    }
}
