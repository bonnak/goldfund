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
    public function customer_receive_level_1_sponsoring()
	  {
	  	$admin = factory(Customer::class)->create();
	    $parent = factory(Customer::class)->create([
	    	'sponsor_id' => $admin->id,
	    	'placement_id' => $admin->id,
	    	'direction' => 'R',
	    ]);

	    //dd($parent->id);

	    $customer2 = [
	      'username' => 'vong_tach2',
	      'first_name' => 'Vong2',
	      'last_name' => 'Tach2',
	      'gender' => 'M',
	      'country_id' => '12',
	      'date_of_birth' => '2017-02-08',
	      'email' => 'vong_tach2@mail.com',
	      'password' => '123456',
	      'password_confirmation' => '123456',
	      'bitcoin_account' => 'rgfegfref',
	      'sponsor_id' => $parent->id,
	      'direction' => 'R',
	      'agree_term_condition' => 'on',
	    ]; 

	    $response = $this->post('/register', $customer2);


	    //dd(Customer::all()->toArray());

	    // $response->assertStatus(200);
	    // $this->assertDatabaseHas('customers', [
	    //   'username' => 'vong_tach2',
	    //   'email' => 'vong_tach2@mail.com',
	    //   'sponsor_id' => $parent->id,
	    //   'placement_id' => $parent->id,
	    //   'direction' => 'R',
	    // ]);
	  }
}
