<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capabilities extends Model
{
    use HasFactory;

    public $table = 'capabilities';
    protected $fillable = [
        'name',
        'org_id',
        'name_org',
        'lead_role',
        'category',
        'status',
        'description',
        'business_planning',
        'business_operation',
        'business_evaluation',
        'business_improvement',
        'business_effectiveness',
        'personel_number',
        'personel_level',
        'personel_productivity',
        'tooltech_tools_installed',
        'tooltech_tech_installed',
        'tooltech_capacity',
        'resource_financial',
        'resource_non_financial',
        'resource_adequacy_allocated'
    ];
}
