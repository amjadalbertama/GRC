<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Groups extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'group_name',
    ];

    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }
}
