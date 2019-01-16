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
*/

//Route::get('/', function () {
//   return view('welcome');
//});

/*-------------Auth routes  -----------------*/
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');

/*-------------Default routes  -----------------*/
Route::get('/home', 'HomeController@index')->name('home');
//Route::post('/home', 'HomeController@index')->name('home');

/*-----------------User Routes------------------*/
Route::get('/changePassword','UserController@showChangePasswordForm');
Route::post('/changePassword','UserController@changePassword')->name('changePassword');

/*----------------Admin Routes------------------*/
/*........ kiosk handling routes ................*/
Route::get('/addKiosk', 'AdminController@addKiosk');

/*........ user handling routes ................*/
Route::get('/userMaint', 'AdminController@userIndex');
Route::get('showDefaultPWD', 'AdminController@showDefaultPWD')->name('showDefaultPWD');
//Route::post('addUser', 'AdminController@addUser')->name('addUser');
//Route::post('addUser', 'Auth\RegisterController@register')->name('addUser');//
Route::post('addUser', 'AdminController@create')->name('addUser');

/*
Route::get('/userMaint', function() {
	return view('userMaint');
});
*/

/*----------------Attendance Routes-------------*/

/*----------------Report Routes-----------------*/



