<?php

namespace App\Exports\Governances;

use App\Models\Governances\Programs;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProgramsExport implements FromView
{
    protected $programs;

    public function __construct($programs)
    {
        $this->programs = $programs;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.programs.exports.index', [
            'programs' => $this->programs,
        ]);
    }
}
