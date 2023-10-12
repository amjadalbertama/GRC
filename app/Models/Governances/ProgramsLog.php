<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramsLog extends Model
{
    use HasFactory;
    public $table = 'programs_log';
    public $timestamps = false;

    protected $fillable = [
        'id_program',
        'reasons',
        'data_deleted',
        'deleted_by',
        'created_at',
        'updated_at',
    ];
}
