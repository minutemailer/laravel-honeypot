<?php

namespace Minutemailer\Honeypot\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditType extends Model
{
    protected $table = 'credit_types';

    public function buckets(): HasMany
    {
        return $this->hasMany(CreditBucket::class);
    }
}
