<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    use HasFactory;
    public $table = 'programs';
    public $timestamps = false;

    protected $fillable = [
        'id_risk_register',
        'program_title',
        'actions',
        'id_type',
        'budget',
        'output',
        'capability_checklist',
        'cba_ratio',
        'schedule',
        'pic',
        'status',
        'notes',
        'id_type_controls',
        'controls',
        'created_at',
        'updated_at',
    ];
}
