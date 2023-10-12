<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLikelihood extends Model
{
    use HasFactory;

    protected $table = 'details_likelihood';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fnum_frequency',
        'range_frequency',
        'type_frequency',
        'likelihood',
        'likelihood_id',
        'range_start',
        'range_end',
        'name_level',
        'code_warna',
        'score_level',

    ];
}
