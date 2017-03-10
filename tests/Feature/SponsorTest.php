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
        $this->seed('PlansTableSeeder');
        $plan = Plan::first();
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
        	'plan_id' => $plan->id 
        ]);

        $response = $this->actingAs($backend_admin, 'api_admin')
                        ->post('api/admin/deposit/' . $direct_right_deposit->id . '/approve');


        $this->assertDatabaseHas('sponsor_earning_commissions', [
        	'sponsor_id' => $parent->id,
        	'deposit_id' => $direct_right_deposit->id
        ]);

  	}
}
