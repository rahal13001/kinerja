<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceGoalChange extends Model
{
    protected $guarded = [];

    protected $casts = [
        'revision_date' => 'date',
    ];

    public function performanceGoal(): BelongsTo
    {
        return $this->belongsTo(PerformanceGoal::class);
    }
}
