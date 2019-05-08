<?php

/*
|--------------------------------------------------------------------------
| Views
|--------------------------------------------------------------------------
| / --> auth/login
| /home --> from login
| 
| /user/changePassword
|
| /admin/userMaint
|
*/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. 
|
|  References: https://laracasts.com/discuss/channels/laravel/routehas
*/

/**** How to return a view right away: DO NOT DO THIS! You need middleware to authenticate everything.
Route::get('/', function () {
   return view('welcome');
});
Route::get('/home1', 'HomeController@home1');
Route::view('/home_orig', 'home_orig');
*/


/*-------------Auth routes  (Authentication Routes...) -----------------*/
//Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Auth::routes(['register' => false]);
//Don't try and replicate these. 
//Route::post('login', 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*-------------Default routes  -----------------*/
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{kiosk}', 'HomeController@showKiosk');
Route::get('/help', 'HomeController@help');


/*----------------Admin Routes------------------*/
Route::get('/userMaint', 'AdminController@userIndex');
Route::get('showDefaultPWD', 'AdminController@showDefaultPWD')->name('showDefaultPWD');
Route::get('hideDefaultPWD', 'AdminController@hideDefaultPWD')->name('hideDefaultPWD');
//Route::post('addUser', 'AdminController@addUser')->name('addUser');
//Route::post('addUser', 'Auth\RegisterController@register')->name('addUser');//
Route::post('addUser', 'AdminController@createUser')->name('addUser');
Route::post('delUser/{id}', 'AdminController@deleteUser')->name('delUser');
Route::post('resetPWD/{id}', 'AdminController@resetPWD');

/*-----------------User Routes------------------*/
Route::get('/changePassword','UserController@showChangePasswordForm');
Route::post('/changePassword','UserController@changePassword')->name('changePassword');
Route::post('/verifyTeacher','UserController@verifyTeacherPWD');


/*----------------Kiosk Routes-------------*/
Route::get(   '/kiosks', 'KioskController@index');
Route::get(   '/kiosks/create', 'KioskController@create');
Route::post(  '/kiosks', 'KioskController@store');
Route::get(   '/kiosks/{kiosk}/show', 'KioskController@show')->name('showKiosk');
Route::get(   '/kiosks/{kiosk}/edit', 'KioskController@edit')->name('editKiosk');
Route::get(   '/kiosks/{kiosk}/showORedit', 
    function($kiosk){        
        $kioskObj=App\Kiosk::find($kiosk);         
        if ( Auth::user()->isKioskAdmin($kioskObj) ) {
            //return redirect()->action('KioskController@edit',[$kiosk]);
            return redirect()->route('editKiosk',[$kiosk]);
        } else {            
            return redirect()->route('showKiosk',[$kiosk]);
            //return redirect()->action('KioskController@show',[$kiosk]);
        }        
    }
);
Route::patch( '/kiosks/{kiosk}', 'KioskController@update');
Route::delete('/kiosks/{kiosk}', 'KioskController@destroy');

/*----------------Kiosk-User Routes-------------*/
// Route::patch('/kiosks/{kiosk}/users/{user}', 'HomeController@index');
// Route::patch('/kiosks/{kiosk}/users/{user}', 'KioskUserController@update');
// Route::post('/kiosks/{kiosk}/attach/{user}', 'KioskUsersController@attach');
// Route::post('/kiosks/{kiosk}/detach/{id}', 'KioskUsersController@detach');

//The following is being done with simple URL redirects .: get method and no CSRF 
Route::get('/kiosks/{kiosk}/users/{user}', 'KioskUserController@toggleKioskAdmin');
Route::get('/kiosks/{kiosk}/attach/{user}', 'KioskUserController@attach');
Route::get('/kiosks/{kiosk}/detach/{user}', 'KioskUserController@detach');

/*----------------Kiosk-Schedule Routes-------------*/
Route::post  ('/kiosks/{kiosk}/schedule', 'KioskController@addSchedule');
Route::delete('/kiosks/{kiosk}/schedule', 'KioskController@delSchedule');
    

/*----------------Terminal Routes-------------*/
Route::get('/terminals/{kiosk}', 'TerminalController@launch')->name('launchTerminal');
Route::get('/terminalAuth/{token}', 'TerminalController@launchViaToken');


/*----------------Log file routes-------------*/
Route::get('/terminals/{kiosk}/toggleStudentID/{loginID}', 'TerminalController@toggleStudentID');
Route::get('/terminalAuth/{kiosk}/toggleStudentID/{loginID}', 'TerminalController@toggleStudentID');
// Route::get('/terminals/{kiosk}/toggleStudent/{student}', 'TerminalController@toggleStudent');
//Route::post('/terminals/{kiosk}/toggleStudent/{student}', 'TerminalController@toggleStudent');
//Route::post('/terminals/{kiosk}/toggleStudent', 'TerminalController@toggleStudent_v2');

Route::get('/terminals/studentFind/{q}', 'TerminalController@listStudents');
Route::get('/terminals/studentFind2/{q}', 'TerminalController@listStudents2');
Route::get('/terminalAuth/studentFind/{q}', 'TerminalController@listStudents');
//Route::get('/terminalAuth/studentFind2/{q}', 'TerminalController@listStudents2');

Route::get('/logs/byKiosk/{id}', 'LogController@kioskLogs');
Route::get('/logs/byKiosk/{id}/{code}', 'LogController@kioskLogs');
Route::get('/logs/byStudent/{id}', 'LogController@studentLogs');
Route::get('/logs/byStudent/{id}/{code}', 'LogController@studentLogs');
Route::get('/logs/byStudentbyKiosk/{id}', 'LogController@studentLogsByKiosk');

//TODO: these should be changed to POST for security
Route::get('/autosignout','LogController@autosignout');
Route::get('/autosignout/{kioskID}','LogController@autosignoutKiosk');

/*----------------Student Routes-------------*/
Route::get('/students', 'StudentController@index');
Route::get('/students/{id}', 'StudentController@show');
Route::get('/courses/', 'StudentController@showCourse');


/*----------------Report Routes-----------------*/


Route::fallback(function () {
    return redirect('home');
});

