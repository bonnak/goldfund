<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;

class UserController extends Controller
{

    public function getProfile(){
        $user_id = auth()->user()->id;
        $user = Customer::with('country')->where('customers.id', $user_id)->first();
        return $user->toArray();
    }

    public function updateProfile(Request $request)
    {
      $user = Customer::find($request->id);

      $user->email = $request->email; 
      $user->password = $request->password; 
  		$user->first_name = $request->first_name; 
  		$user->last_name = $request->last_name; 
  		$user->gender = $request->gender; 
  		$user->country_id = $request->country_id;
  		$user->date_of_birth = $request->date_of_birth; 
  		$user->bitcoin_account = $request->bitcoin_account; 

      return $user->save();
    }
}
