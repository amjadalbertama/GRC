<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    public $table = 'objective';
    public $timestamps = false;

    protected $fillable = [
        'smart_objectives',
        'id_category',
        'id_organization',
        'criteria',
        'type',
        'id_period',
        'status',
        'created_at',
        'updated_at',
    ];

    public function setCriteriaAttribute($value)
    {
        $this->attributes['criteria'] = json_encode($value);
    }

    public function getCriteriaAttribute($value)
    {
        return $this->attributes['criteria'] = json_decode($value);
    }

}
