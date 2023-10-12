<?php

namespace App\Exports\Governances;

use App\Models\Governances\Policies;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PoliciesExport implements FromView
{
    protected $policies;

    public function __construct($policies)
    {
        $this->policies = $policies;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.policies.exports.index', [
            'policies' => $this->policies,
        ]);
    }
}
