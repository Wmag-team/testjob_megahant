<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'last_name' => $this->faker->lastName,
            'name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ];
    }

}
