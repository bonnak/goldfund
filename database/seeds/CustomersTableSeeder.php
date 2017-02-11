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

    factory(Customer::class)->create([
      'username' => 'admin', 
      'email' => 'admin@binary.com', 
      'sponsor_id' => null,
      'direction' => null,
      'bitcoin_account' => '1MXeRULNu6L3En4AKQ5iDgJkBnCLYTC8Nu',
    ]);

    foreach (range(1, 10) as $i) 
    {
      factory(Customer::class)->create(['sponsor_id' => 1, 'placement_id' => $i]);
    }
    
  }
}
