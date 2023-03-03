<?php

namespace Database\Factories;

use App\Models\LifeLogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LifeLog>
 */
class LifeLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeThisMonth()->format('Y-m-d'),
            'message' => fake()->text(),
            'category_id' => 1,
        ];
    }

    public function category(LifeLogCategory $category)
    {
        return $this->state(function (array $attributes) use ($category) {
            return [
                'category_id' => $category->id,
            ];
        });
    }
}
