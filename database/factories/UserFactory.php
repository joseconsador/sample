<?php

use App\Models\User;
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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
    ];
});

$factory->state(\App\Models\User::class, 'owner', []);
$factory->afterCreatingState(\App\Models\User::class, 'owner', function(User $user, Faker $faker) {
    $user->assignRole('owner');
});

$factory->state(\App\Models\User::class, 'admin', []);
$factory->afterCreatingState(\App\Models\User::class, 'admin', function(User $user, Faker $faker) {
    $user->assignRole('admin');
});

$factory->state(\App\Models\User::class, 'regular-user', []);
$factory->afterCreatingState(\App\Models\User::class, 'regular-user', function(User $user, Faker $faker) {
    $user->assignRole('user');
});
