<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    public $table = 'evaluasi';
    protected $fillable = [
        'tittle',
        'description',
        'owner',
        'name_org',
        'date',
        'status',

    ];
}
