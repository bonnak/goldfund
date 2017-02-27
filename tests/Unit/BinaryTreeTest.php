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
	      'direction' => 'L',
	    ]); 

	    $child4R = factory(Customer::class)->create([
	      'sponsor_id' => $root->id, 
	      'placement_id' => $child2R->id,
	      'direction' => 'R',
	    ]); 

	    $child5L = factory(Customer::class)->create([
	      'sponsor_id' => $root->id, 
	      'placement_id' => $child3L->id,
	      'direction' => 'L',
	    ]); 

	    $child1_1 = factory(Customer::class)->create([
	      'sponsor_id' => $child1L->id, 
	      'placement_id' => $child1L->id,
	      'direction' => 'R',
	    ]); 


	    $binary_tree = new BinaryTree();
	    $binary_tree->render($root);

	    $this->assertEquals([
		    	[ 'id' => 2, 'placement_id' => '1', 'direction' => 'L'],
		    	[ 'id' => 3, 'placement_id' => '1', 'direction' => 'R'],
		    	[ 'id' => 4, 'placement_id' => '2', 'direction' => 'L'],
		    	[ 'id' => 5, 'placement_id' => '3', 'direction' => 'R'],
		    	[ 'id' => 6, 'placement_id' => '4', 'direction' => 'L'],
		    ],
				$binary_tree->headChildren()->map(function($el){
		    	return [ 
		    		'id' => $el->id, 
		    		'placement_id' => $el->placement_id,
		    		'direction' =>$el->direction,
		    	];
		    })->toArray()
	    );

	    dd($binary_tree->toArray());
    }
}
