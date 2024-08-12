<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workvalue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'period_id',
        'nilai_kinerja',
        'tahun_kinerja',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
