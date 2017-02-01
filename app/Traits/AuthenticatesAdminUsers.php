<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

trait AuthenticatesAdminUsers
{
	use AuthenticatesUsers;

	protected $redirectTo = '/admin';

  public function username()
  {
    return 'username';
  }

  public function logout(Request $request)
  {
    $this->guard()->logout();
    $request->session()->flush();
    $request->session()->regenerate();

    return redirect($this->redirectTo . '/login');
  }
} 