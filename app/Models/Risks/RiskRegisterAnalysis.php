<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterAnalysis extends Model
{
    use HasFactory;
    protected $table = 'risk_register_analysis';
    public $timestamps = false;

    protected $fillable = [
        "id_risk_register",
        "inherent_risk_likelihood",
        "inherent_risk_likelihood_score",
        "inherent_risk_impact",
        "inherent_risk_impact_score",
        "inherent_risk_score",
        "risk_existing_control_exploit",
        "risk_existing_control_preventif",
        "risk_existing_control_detective",
        "risk_existing_control_responsive",
        "risk_existing_control_exploit_effectiveness",
        "risk_existing_control_exploit_kci",
        "risk_existing_control_preventif_effectiveness",
        "risk_existing_control_preventif_kci",
        "risk_existing_control_detective_effectiveness",
        "risk_existing_control_detective_kci",
        "risk_existing_control_responsive_effectiveness",
        "risk_existing_control_responsive_kci",
        "current_risk_likelihood",
        "current_risk_likelihood_score",
        "current_risk_impact",
        "current_risk_impact_score",
        "current_risk_score",
        'created_at',
        'updated_at',
    ];
}
