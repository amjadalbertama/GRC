<?php

namespace App\Exports\Governances;

use App\Models\Objectegory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ObjectiveCategoryExport implements FromView
{
    protected $objective_category;

    public function __construct($objective_category)
    {
        $this->objective_category = $objective_category;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view(): View
    {
        return view('pages.governance.objective_category.exports.index', [
            'list_objectegory' => $this->objective_category,
        ]);
    }
}
