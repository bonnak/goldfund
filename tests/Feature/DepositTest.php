<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;
use App\Plan;

class DepositTest extends TestCase
{
	use DatabaseMigrations;
  	use DatabaseTransactions;

    /**
     * @test
     */
    public function customer_deposit_expect_pending_and_wait_for_payment_confirm_success()
    {
        $this->seed('PlansTableSeeder');

    	$user = factory(Customer::class)->create();
    	$plan = Plan::find(1);

    	$response = $this->actingAs($user, 'api')
    					->post('/api/deposit', [ 'plan_id' => $plan->id, 'amount' => $plan->min_deposit ]); 

    	$response->assertStatus(200)
    		->assertJson([
    			'cust_id' => $user->id,
    			'plan_id' => $plan->id,
    			'amount' => $plan->min_deposit,
    			'status' => 0,
    		]);
    }
}
