<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;

class PlanTest extends TestCase
{
	use DatabaseMigrations;
  	use DatabaseTransactions;
    
    /**
     * @test
     */
    public function api_receive_plans()
    {
    	$this->seed('PlansTableSeeder');
    	$user = factory(Customer::class)->create();

    	$response = $this->actingAs($user, 'api')->get('/api/plans');  

        $response->assertStatus(200)
	    		->assertJsonStructure([
		                '*' => [
		                	'name',
		                	'min_deposit',
		                	'max_deposit',
		                	'duration',
		                	'daily',
		                	'sponsor_levels' => [
		                		'*' => [
		                			'type',
		                			'commission',
		                		]
		                	]
		                ]
	                ]
	            );
    }
}
