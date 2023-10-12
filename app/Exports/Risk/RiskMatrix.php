<?php

namespace App\Exports\Risk;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RiskMatrix implements FromView
{
    protected $risk_matrix;

    public function __construct($risk_matrix)
    {
        $this->risk_matrix = $risk_matrix;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.risk.risk_matrix.exports.index', [
            'risk_matrix' => $this->risk_matrix,
        ]);
    }
}
