<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periods extends Model
{
    use HasFactory;

    public $table = 'periods';
    protected $fillable = [
        'name_periods',
        'name_org',
        'business_activity',
        'type',
        'status',
        'description',
    ];
}
