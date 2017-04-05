<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Acme\BinaryTree;

class BinaryController extends Controller
{
    public function getData()
    {		
    	// $customer_hierachy = Customer::with('children')
					// 		->where(function($query){
					// 			if( request()->exists('query_username') &&
					// 				trim(request()->input('query_username')) != ''){
					// 				$query->where('username', request()->input('query_username'))
					// 					  ->where('sponsor_id', auth()->user()->id);
					// 			}else{
					// 				$query->where('username', auth()->user()->username);
					// 			} 
					// 		})
					// 		->first();
					

		$query = request()->exists('query_username') && !empty(request()->input('query_username')) ? 
								request()->input('query_username') 
								: auth()->user()->username;

    	$customer_hierachy = Customer::with('children')
							->where('username', $query)
							->orWhere('email', $query)
							->first();

		if(is_null($customer_hierachy)) return null;

		$tree = new BinaryTree();
		$tree->render($customer_hierachy); 

		return $tree->toArray();
    }
}
