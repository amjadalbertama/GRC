<?php

namespace App\Models\Governances;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policies extends Model
{
    protected $table = 'policies';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'types',
        'id_period',
        'id_org',
        'id_status',
        'id_bizact',
        'id_bizenv',
        'capacity',
        'tolerance',
        'appetite',
        'dos',
        'donts',
        'id_category',
        'id_objective',
        'target',
        'smart_objective',
        'created_at',
        'updated_at',
    ];

    public static function generatePolicies($data)
    {
        $insPol = self::insert($data);
        return $insPol;
    }
}
