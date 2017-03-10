<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;
use App\Plan;
use App\User;
use App\Deposit;
use App\Earning;

class EarningTest extends TestCase
{
	use DatabaseMigrations;
  	use DatabaseTransactions;

    /**
     * @test
     */
    public function an_account_can_only_receive_earning_once_perday()
    {
    	$plan = factory(Plan::class)->create();
    	$user = factory(User::class)->create();
    	$customer = factory(Customer::class)->create();
        $deposit = factory(Deposit::class)->create([ 
        	'cust_id' => $customer->id, 
        	'plan_id' => $plan->id,
        ]);
        $earning = factory(Earning::class)->create([ 
        	'cust_id' => $customer->id, 
        	'plan_id' => $plan->id,
        	'deposit_id' => $deposit->id,
        	'amount' => 30,
        ]);

        $response = $this->actingAs($user, 'api_admin')
                        ->post('/api/admin/earning/money/daily',
                        	Deposit::with(['plan', 'owner'])
				                    ->where('id', $deposit->id)
				                    ->first()->toArray()
                        );

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function customer_receive_level_sponsoring()
    {

    }
}
