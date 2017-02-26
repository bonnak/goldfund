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
    public function geneology()
    {
    	$root = factory(Customer::class)->create([
    		'sponsor_id' => null, 
	    	'placement_id' => null,
	    	'direction' => null,
    	]); 

	    $child1L = factory(Customer::class)->create([
	      'sponsor_id' => $root->id, 
	      'placement_id' => $root->id,
	      'direction' => 'L',
	    ]); 

	    $child2R = factory(Customer::class)->create([
	      'sponsor_id' => $root->id, 
	      'placement_id' => $root->id,
	      'direction' => 'R',
	    ]); 

	    $child3L = factory(Customer::class)->create([
	      'sponsor_id' => $root->id, 
	      'placement_id' => $child1L->id,
	      'direction' => 'R',
	    ]); 

	    $child4R = factory(Customer::class)->create([
	      'sponsor_id' => $root->id, 
	      'placement_id' => $child2R->id,
	      'direction' => 'R',
	    ]); 

	    $child5L = factory(Customer::class)->create([
	      'sponsor_id' => $root->id, 
	      'placement_id' => $child3L->id,
	      'direction' => 'R',
	    ]); 

	    $child1_1 = factory(Customer::class)->create([
	      'sponsor_id' => $child1L->id, 
	      'placement_id' => $child1L->id,
	      'direction' => 'L',
	    ]); 


	    $binary_tree = new BinaryTree();
	    $binary_tree->render($root);

	    $this->assertArrayStructure(
	    	[ '*' => 
	    		[
	    			'placement_id',
	    			'sponsor_id',
	    		]
	    	], 
	    	$binary_tree->headChildren()->toArray()
	    );
    }

    public function order_placement_ascending()
    {
    }
}
