<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition()
    {
        return [
            'unique_id' => $this->faker->unique()->uuid,
            'duration' => $this->faker->numberBetween(1, 10),
            'difficulty' => $this->faker->numberBetween(1, 5),
            'provider' => $this->faker->randomElement(['A', 'B', 'C']),
        ];
    }
}
