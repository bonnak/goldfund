<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticatesAdminUsers;

class LoginController extends Controller
{
  use AuthenticatesAdminUsers;

  public function loginForm()
  {
  	if(auth()->check()) return redirect()->back();

  	return view('admin.login');
  }
}
