<?php

namespace App\Exports\Governances;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BizEnv implements FromView
{
    protected $bzenvir;

    public function __construct($bzenvir)
    {
        $this->bzenvir = $bzenvir;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.biz_environment.exports.index', [
            'biz_environment' => $this->bzenvir,
        ]);
    }
}
