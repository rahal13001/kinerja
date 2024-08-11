<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'indicator_id',
        'tahun_achievment',
        'target_achievment',
        'realisasi_achievment',
        'bukti_achievment',
    ];
}
