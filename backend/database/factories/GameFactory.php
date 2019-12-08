<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Game;
use Faker\Generator as Faker;
$factory->define(Game::class, function (Faker $faker) {
    return [
        'location' => $faker->sentence,
        'start_at' => $faker->dateTime,
        'status' => 'ACTIVE',
    ];
});
