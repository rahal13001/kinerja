<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workevaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'workplan_id',
        'tgl_realisasi',
        'kendala',
        'saran',
        'tindak_lanjut',
        'bukti_tindak_lanjut',
        'keterangan',
        'komentar',
    ];

    public function workplan()
    {
        return $this->belongsTo(Workplan::class);
    }

    public function report()
    {
        return $this->belongsToMany(Report::class);
    }
}
