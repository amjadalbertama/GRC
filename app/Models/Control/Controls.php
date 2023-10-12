<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controls extends Model
{
    use HasFactory;
    protected $table = 'controls';
    public $timestamps = false;

    protected $fillable = [
        "title",
        "id_program",
        "status",
        "notes"
    ];
}
