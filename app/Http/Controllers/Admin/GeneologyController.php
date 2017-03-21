<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use Acme\BinaryTree;

class GeneologyController extends Controller
{
    public function getData()
    {
    	$query = request()->exists('query') ? request()->input('query') : 'admin';
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
