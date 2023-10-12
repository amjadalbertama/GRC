<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    use HasFactory;

    public $table = 'biz_environment';
    protected $fillable = [
        'name_environment',
        'period',
        'id_organization',
        'business_activity',
        'type',
        'current_change',
        'influenced_capabilities_process',
        'influenced_capabilities_people',
        'influenced_capabilities_tools',
        'influenced_capabilities_resources',
        'effect',
        'status',
        'source',
        'trend_analysis',
        'description',
        'notes',
        'created_at',
        'updated_at',
    ];
}
