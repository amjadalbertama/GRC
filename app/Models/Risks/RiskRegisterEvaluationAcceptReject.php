<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterEvaluationAcceptReject extends Model
{
    use HasFactory;
    protected $table = 'risk_register_evaluation_accept_reject';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];
}
