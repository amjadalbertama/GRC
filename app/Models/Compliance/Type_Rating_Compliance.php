<?php

namespace App\Models\Compliance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_rating_compliance extends Model
{
    use HasFactory;
    protected $table = 'type_rating_compliance';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name_rating',
        'style_rating',
    ];
}
