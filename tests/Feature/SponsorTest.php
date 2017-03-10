<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Plan;
use App\User;
use App\Customer;
use App\Deposit;

class SponsorTest extends TestCase
{
    use DatabaseMigrations;
  	use DatabaseTransactions;

  	/**
  	 * @test
  	 */
  	public function sponsor_receive_money_after_child_deposit_approve()
  	{
        $plan = $this->getPlan();
        $backend_admin = factory(User::class)->create(['username' => 'admin_backend']);

        $cust_admin = factory(Customer::class)->create([ 'username' => 'admin']);
        $parent = factory(Customer::class)->create([
            'sponsor_id' => $cust_admin->id,
            'placement_id' => $cust_admin->id,
            'direction' => 'R',
        ]);
        $direct_right = factory(Customer::class)->create([
            'sponsor_id' => $parent->id,
            'placement_id' => $parent->id,
            'direction' => 'R',
        ]);
        $direct_right_deposit = factory(Deposit::class)->create([ 
        	'cust_id' => $direct_right->id, 
        	'plan_id' => $plan->id, 
          'amount' => 100,
        ]);

        $direct_right_right = factory(Customer::class)->create([
            'sponsor_id' => $parent->id,
            'placement_id' => $direct_right->id,
            'direction' => 'R',
        ]);


        $response = $this->actingAs($backend_admin, 'api_admin')
                        ->post('api/admin/deposit/' . $direct_right_deposit->id . '/approve');


        $this->assertDatabaseHas('sponsor_earning_commissions', [
        	'sponsor_id' => $parent->id,
        	'deposit_id' => $direct_right_deposit->id,
          'amount' => $direct_right_deposit->amount * 
                      $plan->sponsor_levels()
                          ->where('level', 1)
                          ->first()
                          ->commission,
        ]);
  	}


    private function getPlan()
    {
      $plan = factory(Plan::class)->create([ 
            'name' => 'Platinum',
            'min_deposit' => 3000,
            'max_deposit' => 10000,
            'sponsor' => 0.1, 
            'paring' => 0.1, 
            'daily' => 0.03, 
            'duration' => 60,
            'image' => 'images/logo/3.png'
        ]);

        $plan->sponsor_levels()->createMany([
            [ 'level' => 1, 'type' => 'D', 'commission' => 0.07 ],
            [ 'level' => 2, 'type' => 'I', 'commission' => 0.05 ],
            [ 'level' => 3, 'type' => 'I', 'commission' => 0.03 ],
            [ 'level' => 4, 'type' => 'I', 'commission' => 0.02 ],
            [ 'level' => 5, 'type' => 'I', 'commission' => 0.01 ],
        ]);

        return $plan;
    }
}
