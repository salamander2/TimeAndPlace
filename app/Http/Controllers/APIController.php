<?php

namespace App\Http\Controllers;

use App\Kiosk;
use App\StudentSignedIn;
use Illuminate\Http\Request;

/*
This controller is for API requests that get data. 
All data is returned as JSON. The routes (or functions) never return a view.

It can be extended to include API calls that allow student signin and sign out
- for automating "fake" student movements in this demo database thate doesn't
  have actual real students using it.
But we would need to have some sort of authentication token stored in the ,env file
since there would be no users logging on in order to start the Terminal.

*/

class APIController extends Controller
{
    //Return a list of all "signin/out" kiosks with name and room number.
    public function listKiosks() {
	//only get the signin/signout kiosks
	$kiosks = Kiosk::where('kioskType',0)->get(['id', 'name', 'room']);
	//return($kiosks); //this seems to be JSON encoded data already.
	$data = json_encode($kiosks,true);
	return($data);
    }

    //Return the current attendance for this room
    public function inKiosk(Kiosk $kiosk) {
	//this only works for signin type kiosks. In other cases it is meaningless.
	if ($kiosk->kioskType != 0) {
	    return(json_encode(-1));
         }
	$num = StudentSignedIn::where('kiosk_id', $kiosk->id)->count();
	return json_encode($num);
    }
}
