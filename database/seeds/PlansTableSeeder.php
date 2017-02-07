<?php

use Illuminate\Database\Seeder;
use App\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::truncate();

        factory(Plan::class)->create([ 'name' => 'Plan 1', 'min_price' => 300, 'max_price' => 500 ]);
        factory(Plan::class)->create([ 'name' => 'Plan 2', 'min_price' => 700, 'max_price' => 1000 ]);
        factory(Plan::class)->create([ 'name' => 'Plan 3', 'min_price' => 2000]);
    }
}
