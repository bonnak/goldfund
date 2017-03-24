<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(CountriesTableSeeder::class);
    $this->call(CompanyProfileSeeder::class);
    $this->call(UsersTableSeeder::class);
    $this->call(PlansTableSeeder::class);
    $this->call(CustomersTableSeeder::class);
    //$this->call(DepositsTableSeeder::class);
    $this->call(FaqTableSeeder::class);
  }
}
