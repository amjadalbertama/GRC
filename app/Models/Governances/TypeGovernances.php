<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeGovernances extends Model
{
    use HasFactory;
    protected $table = 'type_governance';
    public $timestamps = false;

    protected $fillable = [
        'environment',
        'policies',
        'created_at',
        'updated_at',
    ];
}
