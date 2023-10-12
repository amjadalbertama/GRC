<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterMonitorings extends Model
{
    use HasFactory;
    protected $table = 'risk_register_monitorings';
    public $timestamps = false;

    protected $fillable = [
        "id_risk_register",
        "risk_monitoring_indicator",
        "risk_monitoring_lower",
        "risk_monitoring_upper",
        "risk_monitoring_status",
        "risk_tolerance_status",
        "risk_tolerance_alarp",
        "risk_update_changes",
        "risk_monitoring_actual_likelihood",
        "risk_monitoring_actual_likelihood_score",
        "risk_monitoring_actual_impact",
        "risk_monitoring_actual_impact_score",
        "risk_monitoring_actual_score",
        'created_at',
        'updated_at',
    ];
}
