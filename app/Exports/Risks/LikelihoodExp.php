<?php

namespace App\Exports\Risks;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LikelihoodExp implements FromView
{
    protected $likeli;

    public function __construct($likeli)
    {
        $this->likeli = $likeli;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.risk.likelihood_criteria.exports.index', [
            'likeli' => $this->likeli,
        ]);
    }
}
