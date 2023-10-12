<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImproveManagement extends Model
{
    use HasFactory;
    public $table = 'review_n_improvement_management';
    public $timestamps = false;

    protected $fillable = [
        'id_review',
        'id_monev',
        'id_audit',
        'id_program',
        'title',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];
}
