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
    Customer::truncate();

    factory(Customer::class)->create(['username' => 'admin', 'email' => 'admin@binary.com']);
    factory(Customer::class, 10)->create();
  }
}
