<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;

class AdminAuthenticationException extends AuthenticationException
{
    public function __construct($message = 'Unauthenticated.', array $guards = [])
    {
        parent::__construct($message, $guards);

        $this->guards = $guards;
    }
}
