<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Checkin::class, function (Faker\Generator $faker) {
    return [
        'signup_date' => date('Y-m-d H:i:s'),
        'checkin_date' => date('Y-m-d H:i:s'),
        'username' => $faker->userName,
        'name' => $faker->name,
        'beer' => $faker->sentence(3),
        'rating' => $faker->numberBetween(0, 5),
        'label_art' => '',
    ];
});
