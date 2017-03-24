<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Acme\BinaryTree;

class BinaryController extends Controller
{
    public function getData()
    {
		// $tree = new BinaryTree();
		// $tree->render(
		// 	Customer::with('children')
		// 			->where('username', auth()->user()->username)
		// 			->first()
		// ); 

		// return $tree->toArray();
		
    	$customer_hierachy = Customer::with('children')
							->where(function($query){
								if( request()->exists('query_username') &&
									trim(request()->input('query_username')) != ''){
									$query->where('username', request()->input('query_username'))
										  ->where('sponsor_id', auth()->user()->id);
								}else{
									$query->where('username', auth()->user()->username);
								} 
							})
							->first();

		if(is_null($customer_hierachy)) return null;

		$tree = new BinaryTree();
		$tree->render($customer_hierachy); 

		return $tree->toArray();
    }
}
