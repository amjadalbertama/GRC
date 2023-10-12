<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance_category extends Model
{
    use HasFactory;

    protected $table = 'compliance_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status',
        'name',
        'description',
        'notes',
    ];
}
