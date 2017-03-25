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
      'country_id' => 1,
      'direction' => null,
      'bitcoin_account' => '1MXeRULNu6L3En4AKQ5iDgJkBnCLYTC8Nu',
    ]);

    

    // $directions = ['L', 'R'];

    // foreach (range(2, 10) as $i) 
    // {
    //   factory(Customer::class)->create([
    //     'id' => $i,
    //     'sponsor_id' => 1, 
    //     'password' => '12345678',
    //     'trans_password' => '87654321',
    //     //'placement_id' => Customer::lastPlacement($direction = $directions[array_rand($directions)], 1)->id, 
    //     'country_id' => 1, 
    //     //'direction' => $direction,
    //   ]);      
    // }



    // // User not yet verify.
    // factory(Customer::class)->create([
    //   'username' => 'unconfirmed',
    //   'sponsor_id' => 1, 
    //   'password' => '12345678',
    //   'trans_password' => '87654321',
    //   'is_active' => false,
    //   'placement_id' => Customer::lastPlacement('L', 1)->id, 
    //   'country_id' => 1, 
    //   'confirmed' => false,
    //   'direction' => 'L',
    // ]);   
    
  }
}
