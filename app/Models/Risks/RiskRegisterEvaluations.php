<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterEvaluations extends Model
{
    use HasFactory;
    protected $table = 'risk_register_evaluations';
    public $timestamps = false;

    protected $fillable = [
        "id_risk_register",
        "risk_evaluation_level",
        "risk_evaluation_appetite",
        "risk_evaluation_benefit",
        "risk_evaluation_accept_reject",
        "risk_evaluation_priority",
        "capability",
        'created_at',
        'updated_at',
    ];
}
