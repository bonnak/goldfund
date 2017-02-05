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
        'type' => null,
        'is_active' => true,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {

    return [
      'user_id' => 1, 
      'surname' => $faker->lastName, 
      'given_name' => $faker->firstName, 
      'gender' => $faker->randomElement(['M', 'F']), 
  		'date_of_birth' => $faker->dateTime, 
  		'ssid' => null, 
  		'block_chain_code' => null, 
  		'sponsor_id' => null,
    ];
});
