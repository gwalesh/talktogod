<?php

namespace Database\Factories;

use App\Models\ChatHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatHistoryFactory extends Factory
{
    protected $model = ChatHistory::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'message' => $this->faker->sentence(),
            'response' => $this->faker->paragraph(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
} 