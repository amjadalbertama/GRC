<?php

namespace App\Exports\Compliance;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Comcat implements FromView
{
    protected $comcat;

    public function __construct($comcat)
    {
        $this->comcat = $comcat;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.compliance.compliance_category.exports.index', [
            'comcat' => $this->comcat,
        ]);
    }
}
