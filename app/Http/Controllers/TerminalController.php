<?php

namespace App\Http\Controllers;

use App\Terminal;
use App\Kiosk;

use Illuminate\Http\Request;

class TerminalController extends Controller
{
    public function launch(Kiosk $kiosk)
    {
        return view('terminal', compact('kiosk'));
    }
    public function launchbp(Kiosk $kiosk)
    {
        return view('bp_terminal', compact('kiosk'));
    }
}
