<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpactCriteria extends Model
{
    use HasFactory;
    protected $table = 'risk_impact_criteria';
    public $timestamps = false;

    protected $fillable = [
        "title",
        "area_count",
        "risk_app_id",
        "obj_id",
        "status",
        "notes"
    ];
}
