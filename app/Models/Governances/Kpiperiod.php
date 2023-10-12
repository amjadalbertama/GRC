<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpiperiod extends Model
{
    use HasFactory;

    public $table = 'kpi_periods';

    protected $fillable = [
        'kpi_id',
        'target',
        'actual',
        'score',
        'end',

    ];
}
