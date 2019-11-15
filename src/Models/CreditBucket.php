<?php

declare(strict_types=1);

namespace Minutemailer\Honeypot\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Minutemailer\Honeypot\Exceptions\InsufficientFundsException;

class CreditBucket extends Model
{
    protected $table = 'credit_buckets';
    protected $guarded = ['id'];
    protected $dates = ['valid_from', 'expires_at'];

    public function scopeValid(Builder $query): Builder
    {
        $today = new \DateTime();

        return $query->where(function(Builder $query) use ($today) {
            $query->whereNull('expires_at')->orWhere('expires_at', '>', $today);
        })->where(function(Builder $query) use ($today) {
            $query->whereNull('valid_from')->orWhere('valid_from', '<=', $today);
        });
    }

    public function use(int $amount)
    {
        if ($amount > $this->available()) {
            throw new InsufficientFundsException();
        }

        $this->increment('used', $amount);
    }

    public function add(int $amount)
    {
        if ($amount < 0) {
            throw new \UnexpectedValueException('Cannot decrease the amount of credits. Use the method `use`');
        }

        $this->increment('amount', $amount);
    }

    public function available(): int
    {
        return $this->attributes['amount'] - $this->attributes['used'];
    }

    public function used(): int
    {
        return $this->attributes['used'];
    }
}
