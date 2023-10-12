<?php

namespace App\Exports\Risk;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ImpactCriteria implements FromView
{
    protected $impact_criteria;

    public function __construct($impact_criteria)
    {
        $this->impact_criteria = $impact_criteria;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.risk.impact_criteria.exports.index', [
            'impact_criteria' => $this->impact_criteria,
        ]);
    }
}
