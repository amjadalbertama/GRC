<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewNImprovement extends Model
{
    use HasFactory;

    public $table = 'review_n_improvement';
    protected $fillable = [
        'tittle',
        'description',
        'status_review',
        'date',
        'status',
        'start_review_period',
        'end_review_period',
    ];
}
