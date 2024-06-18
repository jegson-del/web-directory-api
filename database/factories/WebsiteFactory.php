<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Website>
 */
class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url,
            'ranking' => $this->faker->numberBetween(1, 100), // Random ranking between 1 and 100
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Website $website) {
            $categories = Category::inRandomOrder()->limit($this->faker->numberBetween(1, 5))->get();
            $website->categories()->attach($categories);
        });
    }
}
