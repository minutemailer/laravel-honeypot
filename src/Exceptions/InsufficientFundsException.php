<?php

declare(strict_types=1);

namespace Minutemailer\Honeypot\Exceptions;

class InsufficientFundsException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('Insufficient funds');
    }
}
