<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class TransactionException extends Exception
{
    public function __construct(string $message = "none", int $code = 500, ?Throwable $previous = null)
    {
        $message = "Transaction was not processed. Additional info: $message";
        parent::__construct($message, $code, $previous);
    }

}