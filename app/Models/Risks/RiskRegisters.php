<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisters extends Model
{
    use HasFactory;
    protected $table = 'risk_registers';
    public $timestamps = false;

    protected $fillable = [
        'id_objective',
        'id_risk_identification',
        'types',
        'status',
        'objective_category',
        'risk_event',
        'id_org',
        'owner',
        'additional_description',
        'created_at',
        'updated_at',
    ];
}
