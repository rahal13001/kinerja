<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workagreement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_pk',
        'tahun_pk',
        'data_pk',
        'status_pk',
    ];
}
