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

	factory(Customer::class)->create(['username' => 'admin']);
	factory(Customer::class, 20)->create();
  }
}
