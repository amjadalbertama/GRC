<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class SettingsController extends Controller
{
    //
    public function index()
    {
        $auth = Auth::user();

        return view('settings.index', [
            "data" => $auth,
        ]);
    }

    public function updateSetting(Request $request)
    {
        
    }
}