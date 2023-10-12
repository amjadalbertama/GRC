<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramsKsf extends Model
{
    use HasFactory;
    public $table = 'programs_ksf';
    public $timestamps = false;

    protected $fillable = [
        'id_program',
        'ksf_title',
        'created_at',
        'updated_at',
    ];
}
