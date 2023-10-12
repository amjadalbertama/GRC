<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditActivity extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'audit_activity';
    public $timestamps = false;

    protected $fillable = [
        "id_audit",
        "audit_finding",
        "ofi",
        "recommendation",
        "target_date",
        "status",
        "follow_up_status",
        "notes"        
    ];
}
