<?php

namespace App\Exports\Compliance;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Comobg implements FromView
{
    protected $comobg;

    public function __construct($comobg)
    {
        $this->comobg = $comobg;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.compliance.compliance_obligations.exports.index', [
            'comobg' => $this->comobg,
        ]);
    }
}
