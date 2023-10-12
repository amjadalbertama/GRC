<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAppetite extends Model
{
    use HasFactory;

    public $table = 'risk_appetite';
    protected $fillable = [
        'id_objective',
        'org_id',
        'risk_capacity',
        'risk_appetite',
        'risk_tolerance',
        'id_risk_threshold',
        'risk_limit',
        'status'
    ];
    
    public function objective(){
        return $this->belongsTo('App\Models\Objective', 'id_objective', 'id');
    }

}