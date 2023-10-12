<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMapping extends Model
{
    use HasFactory;
    protected $table = 'status_mapping';
    public $timestamps = false;

    protected $fillable = [
        'status',
        'style',
        'text',
        'created_at',
        'updated_at',
    ];
}
