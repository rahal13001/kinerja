<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cascading extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'nama_cascading',
        'tahun_cascading',
        'data_cascading',
        'status_cascading',
    ];

}
