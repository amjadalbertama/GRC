<?php

namespace App\Models\Control\TypeIssue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIssues extends Model
{
    use HasFactory;

    protected $table = 'type_issue';
    public $timestamps = false;

    protected $fillable = [
        'name_type_issue',
        'created_at',
        'updated_at',
    ];
}
