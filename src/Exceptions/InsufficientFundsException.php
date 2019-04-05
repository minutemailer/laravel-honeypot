<?php

namespace Minutemailer\Honeypot\Exceptions;

class InsufficientFundsException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('Insufficient funds');
    }
}
