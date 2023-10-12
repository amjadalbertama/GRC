<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details_Monev extends Model
{
    use HasFactory;

    protected $table = 'details_monev';
    public $timestamps = false;

    protected $fillable = [
        'type',
        'status',
        'description',
    ];
}
