<?php

declare(strict_types=1);

namespace Minutemailer\Honeypot\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Minutemailer\Honeypot\Exceptions\UnavailableCreditBucketException;
use Minutemailer\Honeypot\Models\CreditBucket;

trait CanHaveCredits
{
    private function getDefaultCreditBucket(): CreditBucket
    {
        $baseQuery = $this->creditBuckets()->whereRaw('`used` <= `amount`');
        $creditBucketsCount = $baseQuery->count();

        if ($creditBucketsCount === 0) {
            throw new UnavailableCreditBucketException();
        } // Only one credit bucket
        elseif ($creditBucketsCount === 1) {
            return $baseQuery->first();
        }

        $expiresOrCreatedFirst = $baseQuery->orderBy('expires_at')->orderBy('created_at')->first();

        if ($expiresOrCreatedFirst->expires_at !== null) {
            return $expiresOrCreatedFirst;
        }

        return $baseQuery->orderBy('created_at')->first();
    }

    public function addCreditBucket(string $name = null, array $options = []): CreditBucket
    {
        $attributes = array_merge(['name' => $name], $options);

        return $this->creditBuckets()->create($attributes);
    }

    public function hasCreditBucket(string $name): bool
    {
        return $this->creditBuckets()->where('name', $name)->exists();
    }

    public function getCreditBucket(string $name = null): CreditBucket
    {
        if ($name === null) {
            return $this->getDefaultCreditBucket();
        }

        $bucket = $this->creditBuckets()->where('name', $name)->first();

        if ($bucket === null) {
            throw new UnavailableCreditBucketException();
        }

        return $bucket;
    }

    public function allCreditBuckets(): HasMany
    {
        return $this->hasMany(CreditBucket::class);
    }

    /**
     * Lists only valid credit buckets
     */
    public function creditBuckets(): HasMany
    {
        return $this->allCreditBuckets()->valid();
    }
}
