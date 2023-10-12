<?php

namespace App\Models\Control;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlsActivity extends Model
{
    use HasFactory;
    protected $table = 'controls_activity';
    public $timestamps = false;

    protected $fillable = [
        "activity_control",
        "id_control",
        "id_kri",
        "id_issue",
        "id_control_issue",
        "threshold_lower",
        "threshold_upper",
        "activity_effectiveness",
        "activity_status",
        "activity_indicator",
        "activity_issue",
        "activity_issue_root_cause",
        "activity_action",
        "activity_result",
        "activity_kci",
        "activity_type",
        "notes",
        "status"
    ];
}
