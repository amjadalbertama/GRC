<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $table = 'issue';
    public $timestamps = false;

    protected $fillable = [
        'id_org',
        'ofi',
        'followup_status',
        'recomendation',
        'category',
        'target_date',
        'information_source',
        'id_kci',
        'id_kpi',
        'id_kri',
        'id_control_activity',
        'id_risk_register',
        'type',
        'title',
        'created_at',
        'updated_at',
    ];
}
