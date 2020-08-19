<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function __construct()
    {     
        $this->middleware('auth');     
    }

    /* This is just for testing any laravel code */
    public function main(Request $request) {
    
        // The hash has to NOT have any of the following characters in it or else it won't work as a URL: . / # : ?
        $secretURL = Hash::make(Str::random(8));
        
        //$secretURL = preg_replace("/[\/\#\?\.:%]/", "", $secretURL);
        $secretURL = preg_replace("/[^\$a-zA-Z0-9]/", "", $secretURL);
        dd($secretURL);
        dd("in test module");
        //or go to a view
    }

    public function testUser(User $user)
    {
        //$user->delete();
        die($user);

        return response()->json('Deleted',200);
    }
}
