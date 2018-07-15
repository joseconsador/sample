<?php

namespace App\Exceptions;

use Exception;

class ApiResponseException extends Exception
{
    public $messageBag;
    
    public function __construct(\Illuminate\Support\MessageBag $messageBag, int $code = 0, Throwable $previous = null)
    {
        $this->messageBag = $messageBag;
        
        parent::__construct($messageBag->toJson(), $code, $previous);
    }
}