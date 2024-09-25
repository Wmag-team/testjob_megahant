<?php

namespace Database\Factories;

use App\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryFactory extends Factory
{
    protected $model = History::class;

    public function definition()
    {
        return [
            'model_id' => $this->faker->uuid,
            'model_name' => $this->faker->word,
            'before' => ['data' => $this->faker->words(3, true)],
            'after' => ['data' => $this->faker->words(3, true)],
            'action' => $this->faker->randomElement(['created', 'updated', 'deleted']),
        ];
    }
}
