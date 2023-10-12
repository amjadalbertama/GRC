<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corebizactivity extends Model
{
    use HasFactory;

    public $table = 'corebizactivity';
    protected $fillable = [
        'name_corebzact',
        'org_id',
        'name_org',
        'lead_role',
        'category',
        'status',
        'description',
    ];
}
