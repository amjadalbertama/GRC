<?php

namespace App\Exports\Governances;

use App\Models\Governances\Programs;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReviewDetailsImprovementExport implements FromView
{
    protected $getRevMnjmt;
    protected $getRevNotes;

    public function __construct($getRevMnjmt, $getRevNotes)
    {
        $this->detrevdet = $getRevMnjmt;
        $this->detrevnote = $getRevNotes;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.governance.review_n_improvement.exports.details', [
            'detrevdet' => $this->detrevdet,
            'detrevnot' => $this->detrevnote,
        ]);
    }
}
