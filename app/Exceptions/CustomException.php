<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public function __construct(
        public $message,
        public int $statusCode = 400
    ) {
        parent::__construct($message, $statusCode);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
