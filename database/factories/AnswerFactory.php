<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph(rand(3, 7), true),
        'user_id' => App\User::pluck('id')->random(),
        'votes_count' => rand(0, 5),
    ];
});

// App\User::pluck('id') return all user ids
// array_random(App\User::pluck('id')->all()) return random user id
