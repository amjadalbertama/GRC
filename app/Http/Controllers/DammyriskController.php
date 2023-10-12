<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DammyriskController extends Controller
{
    public function getHeatmap()
    {
        return view('pages.risk.heatmap.index');
    }

    public function getImpactria()
    {
        return view('pages.risk.impact_criteria.index');
    }

    public function getLikelihood()
    {
        return view('pages.risk.likelihood_criteria.index');
    }

    public function getAppetite()
    {
        return view('pages.risk.risk_appetite.index');
    }

    public function getKri()
    {
        return view('pages.risk.kri.index');
    }

    public function getRegister()
    {
        return view('pages.risk.risk_register.index');
    }
}
