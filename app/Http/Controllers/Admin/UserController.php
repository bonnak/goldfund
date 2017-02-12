<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
	public function users()
	{
		 return User::where('type', 'admin')->paginate(request()->input('size'));
	}
}
