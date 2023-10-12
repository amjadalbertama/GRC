<?php

namespace App\Exports\Governances;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Organization implements FromView
{
    protected $organization;

    public function __construct($organization)
    {
        $this->organization = $organization;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.organization.exports.index', [
            'organization' => $this->organization,
        ]);
    }
}
