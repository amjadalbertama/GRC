<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterIdentifications extends Model
{
    use HasFactory;
    protected $table = 'risk_register_identifications';
    public $timestamps = false;

    protected $fillable = [
        "id_risk_register",
        "risk_event_event",
        "risk_event_category",
        "risk_causes_internal",
        "risk_causes_external",
        "is_kri",
        "kri",
        "kri_lower",
        "kri_upper",
        "kri_parameter",
        "risk_impact_description",
        "risk_impact_areas",
        'created_at',
        'updated_at',
    ];
}
