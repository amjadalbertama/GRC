<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikelihoodCriteria extends Model
{
    use HasFactory;

    protected $table = 'likelihood_criteria';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status',
        'name_periods',
        'period_id',
        'org_id',
        'type',
        'notes',
    ];
}
