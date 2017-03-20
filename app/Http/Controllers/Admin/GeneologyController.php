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
		$tree = new BinaryTree();
		$tree->render(
			Customer::with('children')
					->where('username', 'admin')
					->first()
		); 

		return $tree->toArray();
    }
}  
