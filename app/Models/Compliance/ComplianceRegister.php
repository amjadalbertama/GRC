<?php

namespace App\Models\Compliance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceRegister extends Model
{
    use HasFactory;
    protected $table = 'compliance_register';
    protected $primaryKey = 'id';
    protected $fillable = [
        'risk_id',
        'id_org',
        'compliance_owner',
        'id_compliance_category',
        'fulfillment_status',
        'compliance',
        'rating',
        'organization',
        'objective_id',
    ];
}
