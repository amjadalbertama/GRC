<?php

namespace App\Exports\Controls;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Controls implements FromView
{
    protected $controls;

    public function __construct($controls)
    {
        $this->controls = $controls;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.control.control.exports.index', [
            'controls' => $this->controls,
        ]);
    }
}
