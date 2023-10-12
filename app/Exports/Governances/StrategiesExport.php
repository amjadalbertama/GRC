<?php

namespace App\Exports\Governances;

use App\Models\Governances\Strategies;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StrategiesExport implements FromView
{
    protected $strategies;

    public function __construct($strategies)
    {
        $this->strategies = $strategies;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.strategies.exports.index', [
            'strategies' => $this->strategies,
        ]);
    }
}
