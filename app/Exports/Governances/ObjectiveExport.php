<?php

namespace App\Exports\Governances;

use App\Models\Objective;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ObjectiveExport implements FromView
{
    protected $objective;

    public function __construct($objective)
    {
        $this->objective = $objective;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.objectives.exports.index', [
            'objective' => $this->objective,
        ]);
    }
}
