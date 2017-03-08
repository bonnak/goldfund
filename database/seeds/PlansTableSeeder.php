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
            'name' => 'Basic',
            'min_deposit' => 50,
            'max_deposit' => 300,
            'sponsor' => 0.05, 
            'paring' => 0.05, 
            'daily' => 0.03, 
            'duration' => 60,
            'image' => 'images/logo/1.png'
        ]);

        $plan1->sponsor_levels()->create([ 'type' => 'D', 'commission' => 0.07 ]);

        $plan2 = factory(Plan::class)->create([ 
            'name' => 'Gold',
            'min_deposit' => 400,
            'max_deposit' => 1000,
            'sponsor' => 0.08, 
            'paring' => 0.08, 
            'daily' => 0.03, 
            'duration' => 60,
            'image' => 'images/logo/2.png'
        ]);

        $plan2->sponsor_levels()->createMany([
            [ 'type' => 'D', 'commission' => 0.07 ],
            [ 'type' => 'I', 'commission' => 0.05 ],
        ]);

        $plan3 = factory(Plan::class)->create([ 
            'name' => 'Platinum',
            'min_deposit' => 3000,
            'max_deposit' => 10000,
            'sponsor' => 0.1, 
            'paring' => 0.1, 
            'daily' => 0.03, 
            'duration' => 60,
            'image' => 'images/logo/3.png'
        ]);

        $plan3->sponsor_levels()->createMany([
            [ 'type' => 'D', 'commission' => 0.07 ],
            [ 'type' => 'I', 'commission' => 0.05 ],
            [ 'type' => 'I', 'commission' => 0.03 ],
            [ 'type' => 'I', 'commission' => 0.02 ],
            [ 'type' => 'I', 'commission' => 0.01 ],
        ]);
    }
}
