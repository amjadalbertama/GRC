<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BizEnvironment extends Model
{
    use HasFactory;

    protected $table = 'biz_environment';
    protected $fillable = [
        'name_environment',
        'type',
        'period',
        'id_organization',
        'id_corebizactivity',
        'id_period',
        'id_effect',
        'source',
        'description',
        'status'
    ];
}
