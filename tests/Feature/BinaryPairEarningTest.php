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

class BinaryPairEarningTest extends TestCase
{
	use DatabaseMigrations;
  	use DatabaseTransactions;


    /**
     * @test
     */
    public function it_receive_binary_pair_earning()
    {
    	$parent = factory(Customer::class)->create([
            'sponsor_id' => $this->cust_admin->id,
            'placement_id' => $this->cust_admin->id,
            'direction' => 'R',
        ]);
        $parent_deposit = factory(Deposit::class)->create([ 
            'cust_id' => $parent->id, 
            'plan_id' => $this->plan->id, 
            'amount' => 100,
            'status' => 1,
        ]);


        $child_l = factory(Customer::class)->create([
            'sponsor_id' => $parent->id,
            'placement_id' => $parent->id,
            'direction' => 'L',
        ]);
        $child_l_deposit = factory(Deposit::class)->create([ 
            'cust_id' => $child_l->id, 
            'plan_id' => $this->plan->id, 
            'amount' => 100,
            'status' => 1,
        ]);

        $child_r = factory(Customer::class)->create([
            'sponsor_id' => $parent->id,
            'placement_id' => $parent->id,
            'direction' => 'R',
        ]);
        $child_r_deposit = factory(Deposit::class)->create([ 
            'cust_id' => $child_r->id, 
            'plan_id' => $this->plan->id, 
            'amount' => 100,
        ]);



        $response = $this->actingAs($this->backend_admin, 'api_admin')
                          ->post('api/admin/deposit/' . $child_r_deposit->id . '/approve');



        $this->assertDatabaseHas('binary_earning_commissions', [
            'cust_id'			=> $parent->id,
            'left_child_id'		=> $child_l->id,
            'right_child_id'	=> $child_r->id,
        ]);

    }
}
