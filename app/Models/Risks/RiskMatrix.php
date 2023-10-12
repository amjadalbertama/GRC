<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskMatrix extends Model
{
    use HasFactory;
    protected $table = 'risk_risk_matrix';
    public $timestamps = false;

    protected $fillable = [
        "period_id",
        "notes",
        "status"
    ];
}
