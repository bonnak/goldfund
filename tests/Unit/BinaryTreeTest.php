<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Customer;
use Acme\BinaryTree;

class BinaryTreeTest extends TestCase
{
	use DatabaseMigrations;
	use DatabaseTransactions;

    /**
     * @test
     */
    public function example()
    {
    	$parent = factory(Customer::class)->create([
    		'sponsor_id' => null, 
	    	'placement_id' => null,
	    	'direction' => null,
    	]); 

	    $child1 = factory(Customer::class)->create([
	      'sponsor_id' => $parent->id, 
	      'placement_id' => $parent->id,
	      'direction' => 'L',
	    ]); 

	    $child2 = factory(Customer::class)->create([
	      'sponsor_id' => $parent->id, 
	      'placement_id' => $parent->id,
	      'direction' => 'R',
	    ]); 


	    $binary = new BinaryTree();
	    //$binary->add($parent);
	    $binary->add($child1, function($item){
	    	dd($item);
	    	return tue;
	    });

	    //$binary->toArray();

        $this->assertTrue(true);
    }
}
