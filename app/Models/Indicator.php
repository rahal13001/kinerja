<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicator extends Model
{
    protected $guarded = [];

    public function performanceGoal(): BelongsTo
    {
        return $this->belongsTo(PerformanceGoal::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(Achievement::class);
    }

    public function changes(): HasMany
    {
        return $this->hasMany(IndicatorChange::class);
    }
}
