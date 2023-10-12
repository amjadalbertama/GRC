<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public $table = 'logs';
    protected $fillable = [
        'page',
        'page_id',
        'doc_id',
        'action',
        'actor',
        'created_by',
        'notes',
        'created_at'
    ];
}
