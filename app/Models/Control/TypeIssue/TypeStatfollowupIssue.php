<?php

namespace App\Models\Control\TypeIssue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeStatfollowupIssue extends Model
{
    use HasFactory;

    protected $table = 'type_statfollowup_issue';
    public $timestamps = false;

    protected $fillable = [
        'name_status',
        'style_status',
        'created_at',
        'updated_at',
    ];
}
