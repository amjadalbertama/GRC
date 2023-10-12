<?php

namespace App\Exports\Governances;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Capabilities implements FromView
{
    protected $capabilities;

    public function __construct($capabilities)
    {
        $this->capabilities = $capabilities;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.capabilities.exports.index', [
            'capabilities' => $this->capabilities,
        ]);
    }
}
