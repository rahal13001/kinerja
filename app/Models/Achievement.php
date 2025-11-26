<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    protected $guarded = [];

    protected $casts = [
        'year' => 'integer',
        'target_q1' => 'decimal:2',
        'target_q2' => 'decimal:2',
        'target_q3' => 'decimal:2',
        'target_q4' => 'decimal:2',
        'achievement_q1' => 'decimal:2',
        'achievement_q2' => 'decimal:2',
        'achievement_q3' => 'decimal:2',
        'achievement_q4' => 'decimal:2',
    ];

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(Indicator::class);
    }
}
