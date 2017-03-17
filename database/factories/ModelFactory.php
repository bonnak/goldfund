<?php

use Carbon\Carbon;
use App\Customer;


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
    try {
        $sponsor_id = 1;
        $directions = ['L', 'R'];
        $placement = Customer::lastPlacement($direction = $directions[array_rand($directions)], $sponsor_id)->id;
    } catch (Exception $e) {
        $sponsor_id = null;
        $placement = null;
        $direction = null;
    }

    return [
        'username' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'password' => '12345678',
        'trans_password' => str_random(8),
        'country_id' => $faker->numberBetween(1, 20),
        'is_active' => true,
        'remember_token' => str_random(10),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement(['M', 'F']),
        'date_of_birth' => $faker->dateTime,
        'bitcoin_account' => $faker->uuid,
        'sponsor_id' => $sponsor_id,
        'placement_id' => $placement,
        'direction' => $direction,
        'agree_term_condition' => true,
        'confirmed' => true,
        'verified_token' => $faker->uuid,
        'verified_date' => Carbon::now(),
    ];
});

$factory->define(App\Plan::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->randomElement(['Plan 1', 'Plan 2', 'Plan 3']),
        'description' => null,
        'min_deposit' => 50,
        'max_deposit' => 100,
        'sponsor' => 0, 
        'pairing' => 0.05, 
        'daily' => 0.03, 
        'duration' => 60, 
    ];
});

$factory->define(App\Deposit::class, function (Faker\Generator $faker) {
    return [
        'cust_id' => function () { 
                return factory(App\Customer::class)->create(['placement_id' => Customer::lastPlacement('L', 1)->id 
            ])->id;
        },
        'plan_id' => 1,
        'amount' => 50,
        'status' => 0,
        'issue_date' => null,
        'expire_date' => null,
    ];
});

$factory->define(App\Earning::class, function (Faker\Generator $faker) {
    return [
        'cust_id' => function () { 
                return factory(App\Customer::class)->create(['placement_id' => Customer::lastPlacement('L', 1)->id 
            ])->id;
        },
        'plan_id' => function () { 
            return factory(App\Plan::class)->create()->id;
        },
        'deposit_id' =>function () { 
            return factory(App\Deposit::class)->create()->id;
        },
        'amount' => 50,
    ];
});
