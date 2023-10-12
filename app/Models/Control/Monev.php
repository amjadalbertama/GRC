<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monev extends Model
{
    use HasFactory;

    protected $table = 'monev';
    public $timestamps = false;

    protected $fillable = [
        'id_objective',
        'id_status',
        'id_org',
        'id_kpi',
        'id_kci',
        'id_kri',
        'status',
    ];
}
