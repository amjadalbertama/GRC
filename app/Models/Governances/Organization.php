<?php

namespace App\Models\Governances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    public $table = 'organization';
    protected $fillable = [
        'name_org',
        'upper_org_id',
        'lead_role',
        'status',
        'description',
    ];
}
