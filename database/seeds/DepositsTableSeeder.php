<?php

use Illuminate\Database\Seeder;
use App\Deposit;

class DepositsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deposit::truncate();

        factory(Deposit::class, 5)->create();
    }
}
