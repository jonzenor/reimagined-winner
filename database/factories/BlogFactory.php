<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'date' => fake()->date('m/d/Y', 'now'),
            'status' => 'draft',
            'markdown' => fake()->paragraph(),
            'html' => fake()->paragraph(),
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
            ];
        });
    }

    public function text($text)
    {
        return $this->state(function (array $attributes) use ($text) {
            return [
                'markdown' => $text,
                'html' => $text,
            ];
        });
    }

}
