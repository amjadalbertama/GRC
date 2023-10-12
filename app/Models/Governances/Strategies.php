<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strategies extends Model
{
    use HasFactory;

    public $table = 'strategies';
    public $timestamps = false;
    
    protected $fillable = [
        "title",
        "id_risk_register",
        "id_org",
        "id_objective",
        "status",
        "notes",
        "created_at",
        "updated_at",
    ];
}
