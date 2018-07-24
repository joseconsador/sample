<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Review::class, function (Faker $faker) {
    $created = $faker->dateTimeThisMonth();
    $updated = $faker->dateTimeBetween($created);
    return [
        'user_id' => 1,
        'rating' => $faker->numberBetween(1, 5),
        'comment' => $faker->paragraph,
        'reply' => $faker->randomElement(['', $faker->paragraph]),
        'created_at' => $created,
        'updated_at' => $updated
    ];
});

$factory->state(App\Models\Review::class, 'reply-pending', ['reply' => '']);
