<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReportWorkevaluation extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'workevaluation_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function workevaluation()
    {
        return $this->belongsTo(Workevaluation::class);
    }
}
