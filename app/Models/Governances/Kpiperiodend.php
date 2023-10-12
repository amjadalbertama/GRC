<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpiperiodend extends Model
{
    use HasFactory;

    public $table = 'kpi_periods_end';

    protected $fillable = [
        'kpi_id',
        'target_period_end',
        'actual_period_end',
        'score_period_end',
        'end_period_end',

    ];
}
