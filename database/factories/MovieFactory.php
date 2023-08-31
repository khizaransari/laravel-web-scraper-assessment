<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        // Define default attributes
        return [
            'title' => $this->faker->unique()->word, // Use unique words as titles
            'year' => $this->faker->year,
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'url' => $this->faker->url,
        ];
    }
}
