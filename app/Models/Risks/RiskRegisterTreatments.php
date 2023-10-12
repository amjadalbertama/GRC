<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterTreatments extends Model
{
    use HasFactory;
    protected $table = 'risk_register_treatments';
    public $timestamps = false;

    protected $fillable = [
        "id_risk_register",
        "risk_treatment_strategy",
        "risk_treatment_residual_likelihood",
        "risk_treatment_residual_likelihood_score",
        "risk_treatment_residual_impact",
        "risk_treatment_residual_impact_score",
        "risk_treatment_residual_score",
        "is_monitoring",
        'created_at',
        'updated_at',
    ];
}
