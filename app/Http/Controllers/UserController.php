<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\InvalidPasswordException;

class UserController extends Controller
{
    //
    public function index()
    {
        $userSession = auth()->user();
        return view('layouts.user-dashboard', compact('userSession'));
    }

    public function authorizeTransaction(Request $request)
    {
    	if(is_null($request->trans_password))
    		throw new InvalidPasswordException('This field is required.');

        if(! \Hash::check($request->trans_password, auth()->user()->trans_password))
        {
            throw new InvalidPasswordException('Invalid transaction password');
        }

        return 1;
    }
}
