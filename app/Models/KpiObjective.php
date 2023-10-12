<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiObjective extends Model
{
    use HasFactory;
    public $table = 'kpi_objective';
    protected $fillable = [
        'id',
        'id_kpi',
        'id_objective',
        'kpi',
        'percentage',
        'metric',
        'period',
    ];
}
