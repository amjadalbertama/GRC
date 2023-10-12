<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskMatrixSetting extends Model
{
    use HasFactory;
    protected $table = 'risk_risk_matrix_settings';
    public $timestamps = false;

    protected $fillable = [
        "risk_matrix_id",
        "likelihood_scale",
        "likelihood_scale_threshold",
        "likelihood_scale_tolerance"
    ];
}
