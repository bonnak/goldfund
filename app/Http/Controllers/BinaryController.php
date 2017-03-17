<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Acme\BinaryTree;

class BinaryController extends Controller
{
    public function getData()
    {
		$tree = new BinaryTree();
		$tree->render(
			Customer::with('children')
					->where('username', auth()->user()->username)
					->first()
		); 

		return $tree->toArray();
    }
}
