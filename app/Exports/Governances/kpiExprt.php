<?php

namespace App\Exports\Governances;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class kpiExprt implements FromView
{
    protected $kpi;

    public function __construct($kpi)
    {
        $this->kpi = $kpi;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.governance.kpi.exports.index', [
            'kpi' => $this->kpi,
        ]);
    }
}
