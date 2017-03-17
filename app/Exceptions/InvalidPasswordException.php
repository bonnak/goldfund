<?php 

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

 
class InvalidPasswordException extends HttpException
{
    /**
     * @return void
     */
    public function __construct($message = null)
    { 
      parent::__construct(403, $message);
    }
}