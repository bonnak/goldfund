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
    static $password;

    return [
        'username' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'is_active' => true,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {

    return [
        'username' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('12345678'),
        'is_active' => true,
        'remember_token' => str_random(10),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement(['M', 'F']),
        'date_of_birth' => $faker->dateTime,
        'bitcoin_account' => $faker->uuid,
        'sponsor_id' => 1,
        'placement_id' => null,
        'direction' => $faker->randomElement(['L', 'R'])
    ];
});
