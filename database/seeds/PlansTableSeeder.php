<?php

use Illuminate\Database\Seeder;
use App\Plan;
use App\PlanLevelSponsor;

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
        PlanLevelSponsor::truncate();

        $plan1 = factory(Plan::class)->create([ 
            'name' => 'Plan 1', 
            'min_cost' => 50,
            'max_cost' => 300,
            'sponsor' => 0.05, 
            'paring' => 0.05, 
            'daily' => 0.03, 
            'duration_exp' => 60, 
        ]);

        $plan1->levels()->create([ 'sponsor' => 'D', 'amount' => 0.07 ]);

        $plan2 = factory(Plan::class)->create([ 
            'name' => 'Plan 2', 
            'min_cost' => 400,
            'max_cost' => 1000,
            'sponsor' => 0.08, 
            'paring' => 0.08, 
            'daily' => 0.03, 
            'duration_exp' => 60, 
        ]);

        $plan2->levels()->createMany([
            [ 'sponsor' => 'D', 'amount' => 0.07 ],
            [ 'sponsor' => 'I', 'amount' => 0.05 ],
        ]);

        $plan3 = factory(Plan::class)->create([ 
            'name' => 'Plan 3', 
            'min_cost' => 3000,
            'max_cost' => 10000,
            'sponsor' => 0.1, 
            'paring' => 0.1, 
            'daily' => 0.03, 
            'duration_exp' => 60, 
        ]);

        $plan3->levels()->createMany([
            [ 'sponsor' => 'D', 'amount' => 0.07 ],
            [ 'sponsor' => 'I', 'amount' => 0.05 ],
            [ 'sponsor' => 'I', 'amount' => 0.03 ],
            [ 'sponsor' => 'I', 'amount' => 0.02 ],
            [ 'sponsor' => 'I', 'amount' => 0.01 ],
        ]);
    }
}
