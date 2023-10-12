<?php

namespace App\Models\Control\TypeIssue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCategoryIssue extends Model
{
    use HasFactory;

    protected $table = 'issue_category';
    public $timestamps = false;

    protected $fillable = [
        'name_category_issue',
        'created_at',
        'updated_at',
    ];
}
