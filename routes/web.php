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

/**** How to return a view right away:    */
//Route::get('/', function () {
//   return view('welcome');
//});
/*
Route::get('/userMaint', function() {
	return view('userMaint');
});
*/


/*-------------Default to login page -----------------*/

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');


Route::get('/home', 'HomeController@index')->name('home');

/*-----------------User Routes------------------*/
Route::get('/changePassword','UserController@showChangePasswordForm');
Route::post('/changePassword','UserController@changePassword')->name('changePassword');

/*----------------Admin Routes------------------*/
Route::get('/addKiosk', 'AdminController@addKiosk');

Route::get('/userMaint', 'AdminController@index');

Route::get('showDefaultPWD', 'AdminController@showDefaultPWD')->name('showDefaultPWD');
Route::post('addUser', 'AdminController@create')->name('addUser');
Route::post('delUser', 'AdminController@destroy')->name('delUser');


/*----------------Attendance Routes-------------*/

/*----------------Report Routes-----------------*/



