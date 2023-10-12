<?php

namespace App\Exports\Governances;

use App\Models\Governances\Programs;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReviewImproveExport implements FromView
{
    protected $revimpro;

    public function __construct($revimpro)
    {
        $this->revimpro = $revimpro;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.governance.review_n_improvement.exports.index', [
            'revimpro' => $this->revimpro,
        ]);
    }
}
