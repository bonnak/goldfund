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

  protected function sendFailedLoginResponse(Request $request)
  {
    $errors = [$this->username() => 'Username or password is invalid.'];

    if ($request->expectsJson()) {
        return response()->json($errors, 422);
    }

    return redirect()->back()
        ->withInput($request->only($this->username(), 'remember'))
        ->withErrors($errors);
  }
} 