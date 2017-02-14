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
//        if (User::where('email', '=', $request->email)->count() > 0) {
//            // user found
//            return 'email exist';
//        }
//        if (User::where('username', '=', $request->username)->count() > 0) {
//            // user found
//            return 'user exist';
//        }

        $user = Customer::find($request->id);

        $user->email = $request->email;
        $user->password = $request->password;
  		$user->first_name = $request->first_name; 
  		$user->last_name = $request->last_name; 
  		$user->gender = $request->gender; 
  		$user->country_id = $request->country_id;
  		$user->date_of_birth = $request->date_of_birth; 
  		$user->bitcoin_account = $request->bitcoin_account;
        $user->save();
        return 'update success';
    }
}
