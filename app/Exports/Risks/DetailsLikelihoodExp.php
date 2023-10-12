<?php

namespace App\Exports\Risks;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DetailsLikelihoodExp implements FromView
{
    protected $detlike;

    public function __construct($detlike)
    {
        $this->detlike = $detlike;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.risk.likelihood_criteria.exports.details', [
            'detlike' => $this->detlike,
        ]);
    }
}
