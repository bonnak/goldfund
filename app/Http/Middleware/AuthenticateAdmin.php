<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\AdminAuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Str;

class AuthenticateAdmin
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if(! is_null($user = $this->auth->user()) 
            && Str::lower($user->type) !== 'admin')
        {
            throw new AdminAuthenticationException('Unauthenticated.', $guards);
        }

        $this->authenticate($guards);

        return $next($request);
    }

    private function authenticate(array $guards)
    {
        if (empty($guards) && ! is_null($user = $this->auth->user())) 
        {
            return $user;
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        throw new AdminAuthenticationException('Unauthenticated.', $guards);
    }
}
