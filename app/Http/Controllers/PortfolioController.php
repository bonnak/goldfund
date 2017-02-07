<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class PortfolioController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->limit(10)->get();
        $total_member = Customer::count();

        return view('live', [
        	'customers' => $customers,
        	'total_member' => $total_member
        ]);
    }

    public function live()
    {

    }
}
