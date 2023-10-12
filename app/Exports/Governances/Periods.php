<?php

namespace App\Exports\Governances;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Periods implements FromView
{
    protected $periods;

    public function __construct($periods)
    {
        $this->periods = $periods;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.periods.exports.index', [
            'periods' => $this->periods,
        ]);
    }
}
