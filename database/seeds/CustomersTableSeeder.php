<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Customer;

class CustomersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
  	$faker = Factory::create();

    Customer::truncate();

		$values = [];
		for ($i=0; $i < 100; $i++) {
		  $values []= $faker->unique($maxRetries = 100)->randomDigitNotNull;
		}
		$values = array_unique($values);

		foreach ($values as $val) {
		  factory(Customer::class)->create([ 'user_id' => $val ]);
		}
	}
}
