<?php

namespace App\Models\Compliance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compliance_obligations extends Model
{
    use HasFactory;

    protected $table = 'compliance_obligations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_org',
        'name_obligations',
        'compliance_source',
        'rating',
        'name_org',
        'compliance_owner',
    ];
}
