<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ksf extends Model
{
    use HasFactory;
    public $table = 'ksf';
    protected $fillable = [
        'tittle',
        'description',
        'owner',
        'name_org',
        'date',
        'status',

    ];
}
