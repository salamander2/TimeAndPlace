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
| Resourceful controllers
|--------------------------------------------------------------------------
Actions Handled By Resource Controller
Verb        URI                 Action      Route Name
GET         /photos             index()       photos.index
GET         /photos/create      create()      photos.create
POST        /photos             store()       photos.store
GET         /photos/{photo}     show()        photos.show
GET         /photos/{photo}/edit edit()       photos.edit
PUT/PATCH   /photos/{photo}     update()      photos.update
DELETE      /photos/{photo}     destroy()     photos.destroy
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

   Named routes: used so that you can write this
        <a class="btn btn-info" href="{{ route('hideDefaultPWD') }}"><b>Hide default password</b></a>

*/

/**** How to return a view right away: 
	DO NOT DO THIS! You need middleware to authenticate everything.
	But you can add Middleware here. Can it be added to functions?

//get a URL, return a view
Route::get('/', function () {
   return view('welcome');
});

//get URL, return data from a controller function
Route::get('/home1', 'HomeController@home1');

//return a view directly (no function needed)
Route::view('/home2', '/other/home2');
*/


/*-------------Auth routes  (Authentication Routes...) -----------------*/
//Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Auth::routes(['register' => false]);
//Don't try and replicate these. 
//Route::post('login', 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*-------------Default routes  -----------------*/
//Route::get('/', function(){ return view('login'); });
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{kiosk}', 'HomeController@showKiosk');
Route::get('/help', 'HomeController@help');


/*----------------Admin Routes------------------*/
Route::get('/userMaint', 'AdminController@userIndex');
//Route::post('addUser', 'AdminController@addUser')->name('addUser');
//Route::post('addUser', 'Auth\RegisterController@register')->name('addUser');//
Route::post('addUser', 'AdminController@createUser')->name('addUser');
//Route::post('AJAXdelUser/{user}', 'AjaxController@deleteUser')->middleware('admin');
Route::post('delUser/{user}', 'AdminController@deleteUser');
//Route::post('resetPWD/{id}', 'AdminController@resetPWD');

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
Route::get('/terminals/studentFind2/{q}', 'TerminalController@listStudents2'); //from topnavbar.blade
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
Route::get('/allstudents', 'StudentController@index');
Route::get('/students/{id}', 'StudentController@show');
Route::get('/studentsJSON/{id}', 'StudentController@showJSON');
Route::get('/allcourses', 'ClassListController@showCourses');
Route::get('/classlists', 'ClassListController@classlist');
Route::post('/classlists/show', 'ClassListController@show');
Route::post('/classlists/showContacts', 'ClassListController@showContacts');

/*----------------Event Routes-----------------*/
Route::get('/events/create/{kiosk}', 'EventController@create');
Route::post('/events', 'EventController@store');
Route::get('/events/settings/{id}', 'EventController@settings');
Route::get('/events/terminal/{id}', 'EventController@terminal');
Route::get('/events/report/{id}', 'ReportController@eventReport');
Route::get('/events/reportPrint/{id}', 'ReportController@eventReportPrint'); //printable report
//Route::get('/events/{id}/addStudents', 'EventController@addStudents');
Route::post('/events/addStudentsByCourse', 'EventController@addStudentsByCourse');
Route::post('/events/copyStudentList', 'EventController@copyStudentList');
Route::get('/events/{event}/signInStudent/{loginID}', 'EventController@signInStudent');
//TODO Choose one and get it working
Route::post('/events/removeStudent/', 'EventController@removeStudent');
Route::get('/events/removeStudent/{event}/{studentID}', 'EventController@removeStudent');
Route::post('/events/removeStudent/{event}/{studentID}', 'EventController@removeStudent');
//TODO Choose one and get it working
//Route::get('/events/addStudent/{event}/{student}', 'EventController@addStudent');
//Route::post('/events/addStudent/{event}/{student}', 'EventController@addStudent');
Route::post('/events/addStudent', 'EventController@addStudent');
Route::post('/events/clearStudents', 'EventController@clearStudents');

/*---------------- AJAX routes ------------------*/
//Only put POST routes here. // adding multiple middlewares: middleware('first', 'second');
//Middleware can also be added in AjaxController using the ->only() and ->except() methods
Route::post('AJAXresetPWD/{id}', 'AjaxController@resetPWD')->middleware('admin');
Route::post('showDefaultPWD', 'AjaxController@showDefaultPWD')->name('showDefaultPWD');

/*---------------- Report Routes-----------------*/
//This is for attendance report
Route::get('/reports', 'ReportController@attendance');
Route::get('/reports/{kiosk}', 'ReportController@attendance')->defaults('code', 'A'); //parameter 'A' = all, 'M' = current month
Route::get('/reports/attend/{kiosk}', 'ReportController@attendance');
Route::get('/reports/attend/{kiosk}/{code}', 'ReportController@attendance');
Route::get('/reportsPrint/attend/{kiosk}', 'ReportController@attendancePrint');
Route::get('/reportsPrint/attend/{kiosk}/{code}', 'ReportController@attendancePrint');
Route::get('/reportsPrint/{kiosk}', 'ReportController@attendancePrint')->defaults('code', 'A'); //parameter 'A' = all, 'M' = current month

//This is the summary report of the normal LOG view -- sign in/out kiosks
Route::get('/reports/summary/{kiosk}', 'LogController@summaryReport');

/*---------------- Locker Routes-----------------*/
Route::get('/lockers', 'LockerController@main'); //from control-sidepanel button
Route::post('verifyHomeRoom', 'LockerController@verifyHomeRoom');
Route::get('/lockers/homeroom/{code}', 'LockerController@homeroom'); //from main (locker info button)
Route::get('/lockers/reports/course/{code}', 'LockerController@courseRpt');
Route::get('/lockers/edit', 'LockerController@edit'); //from main (edit button)
Route::get('/lockers/edit/{locker}', 'LockerController@editLocker'); //used by return redirect()->back(); in setStatus
Route::post('/lockers/edit/{locker}', 'LockerController@editLocker'); //from edit
Route::post('/lockers/student/{id}', 'LockerController@updateLocker'); //from homeroom
Route::post('/lockers/addStudent/{locker}', 'LockerController@addStudent'); //from edit
Route::post('/lockers/delStudent/{locker}', 'LockerController@delStudent'); //from edit
Route::post('/lockers/newCombo/{locker}', 'LockerController@newCombo'); //from edit
Route::post('/lockers/setStatus/{locker}', 'LockerController@setStatus'); //from edit
Route::get('/lockers/listing', 'LockerController@listing'); //from main (reports button)
Route::post('/lockers/massAssign', 'LockerController@massAssign'); //from listing


/*---------------- Testing Routes-----------------*/
Route::get('/testing', 'TestController@main');
Route::get('/testing/{user}', 'TestController@testUser');

/* ---------------- Fallback Route --------------*/
Route::fallback(function () {
    return redirect('home');
    //abort(404,'Page Not Found.');
});

