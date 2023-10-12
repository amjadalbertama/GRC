<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpactCriteriaLevel extends Model
{
    use HasFactory;
    protected $table = 'risk_impact_criteria_level';
    public $timestamps = false;

    protected $fillable = [
        "impact_id",
        "impact_level",
        "impact_value",
    ];
}
