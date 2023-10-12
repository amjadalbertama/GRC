<?php

namespace App\Exports\Controls;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AuditActivity implements FromView
{
    protected $audit_activity;

    public function __construct($audit_activity)
    {
        $this->audit_activity = $audit_activity;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.control.audit.exports.activity', [
            'audit_activity' => $this->audit_activity,
        ]);
    }
}
