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

        factory(Plan::class)->create([ 
            'name' => 'Plan 1', 
            'min_cost' => 30,
            'max_cost' => 300,
            'sponsor' => 0.05, 
            'paring' => 0.05, 
            'daily' => 0.01, 
            'duration_exp' => 180, 
        ]);

        factory(Plan::class)->create([ 
            'name' => 'Plan 2', 
            'min_cost' => 500,
            'max_cost' => 1500,
            'sponsor' => 0.08, 
            'paring' => 0.08, 
            'daily' => 0.011, 
            'duration_exp' => 180, 
        ]);

        factory(Plan::class)->create([ 
            'name' => 'Plan 3', 
            'min_cost' => 2000,
            'max_cost' => 5000,
            'sponsor' => 0.1, 
            'paring' => 0.1, 
            'daily' => 0.015, 
            'duration_exp' => 180, 
        ]);
    }
}
