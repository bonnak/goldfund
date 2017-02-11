<?php

use Carbon\Carbon;
use App\Acme\Binary;


$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = 'secret',
        'is_active' => true,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {

    return [
        'username' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'password' => '12345678',
        'country_id' => $faker->numberBetween(1, 20),
        'is_active' => true,
        'remember_token' => str_random(10),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement(['M', 'F']),
        'date_of_birth' => $faker->dateTime,
        'bitcoin_account' => $faker->uuid,
        'sponsor_id' => 1,
        'placement_id' => null,
        'direction' => $faker->randomElement(['L', 'R']),
        'agree_term_condition' => true,
        'email_verified' => true,
        'verified_token' => null,
    ];
});

$factory->define(App\Plan::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->randomElement(['Plan 1', 'Plan 2', 'Plan 3']),
        'description' => null,
        'min_price' => null,
        'max_price' => null,
    ];
});

$factory->define(App\Deposit::class, function (Faker\Generator $faker) {
    $last_placement_id = Binary::lastPlacement('L', 1)->id;

    return [
        'cust_id' => factory(App\Customer::class)->create([ 'placement_id' => $last_placement_id ])->id,
        'plan_id' => 1,
        'amount' => 300,
        'issue_date' => Carbon::now(),
        'expire_date' => Carbon::now()->addDay(30),
        'invoice_attachment' => substr($faker->image('public/images/invoices'), 6),
    ];
});
