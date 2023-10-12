<?php

namespace App\Exports\Controls;

use App\Models\Environment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IssueExprt implements FromView
{
    protected $issueexp;

    public function __construct($issueexp)
    {
        $this->issueexp = $issueexp;
    }

    /**
     * @return \Illuminate\Support\view
     */
    public function view(): View
    {
        return view('pages.control.issues.exports.index', [
            'issueexp' => $this->issueexp,
        ]);
    }
}
