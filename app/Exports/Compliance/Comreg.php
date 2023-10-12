<?php

namespace App\Exports\Compliance;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Comreg implements FromView
{
    protected $comreg;

    public function __construct($comreg)
    {
        $this->comreg = $comreg;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.compliance.compliance_register.exports.index', [
            'comreg' => $this->comreg,
        ]);
    }
}
