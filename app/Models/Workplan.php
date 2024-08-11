<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workplan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'indicator_id',
        'nama_kegiatan',
        'tgl_rencana',
        'kategori_kegiatan',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function workevaluations()
    {
        return $this->hasMany(Workevaluation::class);
    }
}
