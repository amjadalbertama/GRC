<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskIdentification extends Model
{
    use HasFactory;
    public $table = 'risk_identifications';

    protected $fillable = [
        'id_objective',
        'risk_compliance_sources',
        'type',
        'risk_event'

    ];
}
