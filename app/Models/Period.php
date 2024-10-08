<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode',
    ];

    public function workvalues()
    {
        return $this->hasMany(Workvalue::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Workevaluation::class);
    }
}
