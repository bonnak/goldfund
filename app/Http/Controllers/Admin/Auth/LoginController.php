<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\AuthenticatesAdminUsers;

class LoginController extends Controller
{
  use AuthenticatesAdminUsers;

  public function __construct()
  {
      $this->middleware('admin.guest', ['except' => 'logout']);
  }

  public function loginForm()
  {
  	return view('admin.login');
  }
}
