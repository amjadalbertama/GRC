<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskThreshold extends Model
{
    use HasFactory;

    public $table = 'risk_threshold';
    protected $fillable = [
        'id_risk_appetite',
        'color',
        'deviasi_order',
        'deviasi',
        'description',
        'type',
        'status'
    ];
}
