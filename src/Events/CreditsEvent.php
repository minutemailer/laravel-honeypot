<?php

declare(strict_types=1);

namespace Minutemailer\Honeypot\Events;

use Illuminate\Queue\SerializesModels;
use Minutemailer\Honeypot\Models\CreditBucket;

class CreditsEvent
{
    use SerializesModels;

    protected $bucket;
    protected $amount;
    protected $message;
    protected $metadata;

    public function __construct(CreditBucket $bucket, int $amount)
    {
        $this->bucket = $bucket;
        $this->amount = $amount;
    }

    public function getBucket(): CreditBucket
    {
        return $this->bucket;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    public function setMetaData(?array $metadata): void
    {
        $this->metadata = $metadata;
    }
}
