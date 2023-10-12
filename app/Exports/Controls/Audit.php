<?php

namespace App\Exports\Controls;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Audit implements FromView
{
    protected $controls;

    public function __construct($audit)
    {
        $this->audit = $audit;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.control.audit.exports.index', [
            'audit' => $this->audit,
        ]);
    }
}
