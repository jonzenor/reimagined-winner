<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LifeLog;

class HomeController extends Controller
{
    public function home()
    {
        $lifeLogs = LifeLog::all();

        return view('home', [
            'lifeLogs' => $lifeLogs,
        ]);
    }
}
