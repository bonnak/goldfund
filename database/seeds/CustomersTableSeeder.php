<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Customer;
use App\TempPasswordStore;

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
    TempPasswordStore::truncate();

    factory(Customer::class)->create([
      'username' => 'admin', 
      'email' => 'admin@binary.com', 
      'sponsor_id' => null,
      'country_id' => 1,
      'direction' => null,
      'bitcoin_account' => '1MXeRULNu6L3En4AKQ5iDgJkBnCLYTC8Nu',
    ]);

    foreach (range(2, 10) as $i) 
    {
      factory(Customer::class)->create([
        'id' => $i,
        'sponsor_id' => 1, 
        'password' => '12345678',
        'trans_password' => 'abcdefgh',
        'placement_id' => $i, 
        'country_id' => 1, 
      ]);      
    }



    // User not yet verify.
    factory(Customer::class)->create([
      'id' => 11,
      'sponsor_id' => 1, 
      'password' => '12345678',
      'trans_password' => 'abcdefgh',
      'is_active' => false,
      'placement_id' => 10, 
      'country_id' => 1, 
      'confirmed' => false,
    ]);      

    // factory(TempPasswordStore::class)->create([
    //   'cust_id' => 11,
    //   'password' => '12345678',
    //   'trans_password' => 'abcdefgh',
    // ]);
    
  }
}
