<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewLogs extends Model
{
    use HasFactory;
    protected $table = 'review_logs';
    public $timestamps = false;

    protected $fillable = [
        "page",
        "module_id",
        "reviewer",
        "notes",
        "status",
        "created_by",
        "role_id",
        'created_at',
        'updated_at',
    ];
}
