<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskRegisterStatusMapping extends Model
{
    use HasFactory;
    protected $table = 'risk_register_status_mapping';
    public $timestamps = false;

    protected $fillable = [
        'status',
        'styles',
        'created_at',
        'updated_at',
    ];
}
