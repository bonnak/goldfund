<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;

class CustomerController extends Controller
{
  public function customers()
  {
  	return Customer::paginate(request()->input('size'));
  }
}
