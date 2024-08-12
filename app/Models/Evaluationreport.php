<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluationreport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'period_id',
        'team_id',
        'indicator_id',
        'nama_laporan',
        'tahun_laporan',
        'data_laporan',
        'status_laporan',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
