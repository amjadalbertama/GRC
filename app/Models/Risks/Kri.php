<?php

namespace App\Models\Risks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kri extends Model
{
    use HasFactory;
    protected $table = 'kri';
    public $timestamps = false;

    protected $fillable = [
        "kri",
        "kri_parameter",
        "kri_lower",
        "kri_upper",
        "obj_id",
        "id_risk_register",
        "monitor_status",
    ];
}
