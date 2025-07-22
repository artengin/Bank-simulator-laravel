<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        $faker = app(Faker::class);

        return [
            'first_name' => $faker->word,
            'last_name' => $faker->word,
            'ssn' => $faker->ssn,
            'phone' => $faker->word,
            'email' => $faker->email,
            'status' => $faker->word,
        ];
    }
}
