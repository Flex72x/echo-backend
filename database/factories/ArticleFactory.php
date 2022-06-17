<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'img' => $this->faker->imageUrl(500, 500),
            'anons' => $this->faker->realText(20),
            'text' => $this->faker->realText(100),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
