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
    protected $type;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
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
