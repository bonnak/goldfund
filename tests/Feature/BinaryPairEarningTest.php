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
            'amount' => 80,
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
            'amount'			=> $child_l_deposit->amount * $child_r_deposit->plan->pairing,
        ]);

    }

    /**
     * @test
     */
    public function it_not_receive_binary_pair_earning_because_only_either_left_nor_right_child_deposited()
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



        $this->assertDatabaseMissing('binary_earning_commissions', [
            'cust_id'			=> $parent->id,
            'left_child_id'		=> $child_l->id,
            'right_child_id'	=> $child_r->id
        ]);

    }

    /**
     * @test
     */
    public function it_not_receive_binary_pair_earning_because_only_either_left_nor_right_child_deposit_is_approved()
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
            'amount' => 80,
            'status' => 0,
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



        $this->assertDatabaseMissing('binary_earning_commissions', [
            'cust_id'			=> $parent->id,
            'left_child_id'		=> $child_l->id,
            'right_child_id'	=> $child_r->id
        ]);

    }


    /**
     * @test
     */
    public function sponsor_deposit_must_be_active_in_order_to_receive_binary_pair_earning()
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
            'status' => 0,
        ]);


        $child_l = factory(Customer::class)->create([
            'sponsor_id' => $parent->id,
            'placement_id' => $parent->id,
            'direction' => 'L',
        ]);
        $child_l_deposit = factory(Deposit::class)->create([ 
            'cust_id' => $child_l->id, 
            'plan_id' => $this->plan->id, 
            'amount' => 80,
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



        $this->assertDatabaseMissing('binary_earning_commissions', [
            'cust_id'			=> $parent->id,
            'left_child_id'		=> $child_l->id,
            'right_child_id'	=> $child_r->id
        ]);

    }

    /**
     * @test
     */
    public function sponsor_should_receive_binary_pair_earning_only_once_on_the_same_pair()
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


        // First deposit.
        $child_l = factory(Customer::class)->create([
            'sponsor_id' => $parent->id,
            'placement_id' => $parent->id,
            'direction' => 'L',
        ]);
        $child_l_deposit = factory(Deposit::class)->create([ 
            'cust_id' => $child_l->id, 
            'plan_id' => $this->plan->id, 
            'amount' => 80,
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
            'cust_id'           => $parent->id,
            'left_child_id'     => $child_l->id,
            'right_child_id'    => $child_r->id
        ]);



        // Second deposit
        $child_l_deposit_2 = factory(Deposit::class)->create([ 
            'cust_id' => $child_l->id, 
            'plan_id' => $this->plan->id, 
            'amount' => 80,
        ]);

        $response = $this->actingAs($this->backend_admin, 'api_admin')
                          ->post('api/admin/deposit/' . $child_r_deposit->id . '/approve');

       
        $this->assertTrue($parent->binary_earning_commissions->count() === 1);
    }
}
