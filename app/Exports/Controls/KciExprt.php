<?php

namespace App\Exports\Controls;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KciExprt implements FromView
{
    protected $kciexp;

    public function __construct($kciexp)
    {
        $this->kciexp = $kciexp;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.control.kci.exports.index', [
            'kciexp' => $this->kciexp,
        ]);
    }
}
