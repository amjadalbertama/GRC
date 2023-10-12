<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kci extends Model
{
    use HasFactory;

    protected $table = 'kci';
    public $timestamps = false;

    protected $fillable = [
        'id_org',
        'title',
        'threshold_lower',
        'threshold_upper',
        'id_control_activity',
        'monitoring_status',
        'created_at',
        'updated_at',
    ];
}

