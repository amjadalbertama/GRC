<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectegory extends Model
{
    use HasFactory;

    public $table = 'objectegory';

    protected $fillable = [
        'title',
        'description',
        'status',
        'id_organization',
        'notes'

    ];
}
