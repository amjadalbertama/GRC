<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliciesKpi extends Model
{
    use HasFactory;
    protected $table = 'policies_kpi';
    public $timestamps = false;

    protected $fillable = [
        'id_policies',
        'indicators',
        'metric',
        'period',
        'percentage',
        'created_at',
        'updated_at',
    ];
}
