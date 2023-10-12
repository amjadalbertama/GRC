<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audit extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'audit';
    public $timestamps = false;

    protected $fillable = [
        "type",
        "id_org",
        "id_period",
        "status",
        "finding",
        "source",
        "id_source",
        "target_date",
        "reason"
    ];
}
