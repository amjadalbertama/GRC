<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterTreatmentStrategy extends Model
{
    use HasFactory;
    protected $table = 'risk_register_treatment_strategy';
    public $timestamps = false;

    protected $fillable = [
        "id_risk_register",
        "id_treatment",
        "id_type",
        "program_title",
        'created_at',
        'updated_at',
    ];
}
