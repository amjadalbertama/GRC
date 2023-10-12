<?php

namespace App\Models\Control\TypeIssue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueInformationSource extends Model
{
    use HasFactory;

    protected $table = 'issue_information_source';
    public $timestamps = false;

    protected $fillable = [
        'name_information_source',
        'created_at',
        'updated_at',
    ];
}
