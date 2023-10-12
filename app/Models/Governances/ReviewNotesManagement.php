<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewNotesManagement extends Model
{
    use HasFactory;
    public $table = 'review_n_improvement_notes_recommend';
    public $timestamps = false;

    protected $fillable = [
        'id_review_management',
        'from',
        'description',
        'created_at',
        'updated_at',
    ];
}
