<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpactCriteriaArea extends Model
{
    use HasFactory;
    protected $table = 'risk_impact_criteria_area';
    public $timestamps = false;

    protected $fillable = [
        "impact_id",
        "impact_area",
        "impact_level",
        "impact_area_value",
        "impact_area_description",
        "impact_area_type"
    ];
}
