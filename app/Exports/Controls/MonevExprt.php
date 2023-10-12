<?php

namespace App\Exports\Controls;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MonevExprt implements FromView
{
    protected $monevexp;

    public function __construct($monevexp)
    {
        $this->monevexp = $monevexp;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.control.monev.exports.index', [
            'monevexp' => $this->monevexp,
        ]);
    }
}
