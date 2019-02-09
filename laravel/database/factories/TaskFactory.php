<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'status' => $faker->randomElement(['todo', 'doing', 'done']),
        'user_id' => factory(\App\User::class),
        'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
    ];
});
