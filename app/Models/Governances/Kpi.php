<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    use HasFactory;

    public $table = 'kpi';
    protected $fillable = [
        'id_policies_kpi',
        'id_org',
        'id_capabilities',
        'id_policies',
        'percentage',
        'metric',
        'period',
        'title',
        'total',
        'mentoring_status',

    ];
}
