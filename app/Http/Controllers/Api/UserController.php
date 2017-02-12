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

    public function updateProfile($data){
        $user_id = auth()->user()->id;
        dd($data);
        $user = Customer::find($user_id);
        $user->first_name = $data->first_name;

        $user->save();
    }
}
