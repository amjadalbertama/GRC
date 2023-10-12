<?php

namespace App\Models\Compliance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeStatusFulfilled extends Model
{
    use HasFactory;
    protected $table = 'compliance_status_fulfilled';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name_status',
        'style_status',
    ];
}
