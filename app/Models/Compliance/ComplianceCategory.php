<?php

namespace App\Models\Compliance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceCategory extends Model
{
    use HasFactory;

    protected $table = 'compliance_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status',
        'name',
        'description',
        'type',
        'notes',
    ];
}
