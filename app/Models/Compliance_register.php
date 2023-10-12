<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance_register extends Model
{
    use HasFactory;
    protected $table = 'compliance_register';
    protected $primaryKey = 'id';
    protected $fillable = [
        'risk_id',
        'compliance',
        'rating',
        'organization',
        'objective_id',
    ];
}
