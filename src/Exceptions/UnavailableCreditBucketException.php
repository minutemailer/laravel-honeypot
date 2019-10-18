<?php

declare(strict_types=1);

namespace Minutemailer\Honeypot\Exceptions;

class UnavailableCreditBucketException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('No credit bucket is available');
    }
}
