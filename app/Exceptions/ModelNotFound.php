<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ModelNotFound extends Exception
{
    public function __construct(string $message = "none", int $code = 404, ?Throwable $previous = null)
    {
        $message = "Entity not found. Additional info: $message";
        parent::__construct($message, $code, $previous);
    }

}