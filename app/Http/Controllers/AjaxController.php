<?php

namespace App\Http\Controllers;

use App\User;
use App\Kiosk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function __construct()
    {       
        $this->middleware('auth');
        //$this->middleware('admin');
		
    }

    public function resetPWD(String $id) 
    {
        $defaultPWD = env('DEFAULT_PWD','G0^W$#SS54lhx');
        $user = User::find($id);
        $user->password = Hash::make($defaultPWD);
        $user->defaultPWD = 1;
        $user->save();
        return response()->json(['status' => 'success']);
    }

    public function showDefaultPWD()
    {
        $defaultPWD = env('DEFAULT_PWD', '--none--');
        return response()->json($defaultPWD, 200);
    }

    
}
