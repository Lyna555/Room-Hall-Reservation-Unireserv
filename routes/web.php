<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

////welcome
Route::get('/', function(){ return view('welcome');});
Route::get('/contactus', function(){ return view('contactus');});
Route::get('/welcomeContactus', function(){ return view('welcomeContactus');});
Route::get('/mailcontact','ContactController@contactus');
Route::get('/welcomeContactusMail','ContactController@welcomeContactus');

////login
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function(){ return view('dashboard');})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/redirects','HomeController@index');

////home
Route::get('/admin/home','HomeController@index')->name('/admin/home');
Route::get('/user/home','HomeController@index')->name('/user/home');

////admin

//admin/navbar
Route::get('/admin/calendar', "CalendarController@adminCalendar")->name('/admin/calendar');
Route::get('/admin/profile', function(){ return view('admin.profile.show');})->name('/admin/profile');
Route::get('/admin/showReser',"ReservationController@showReserAdmin")->name('/admin/showReser');
Route::get('/admin/email', "MessageController@emails")->name('/admin/email');
Route::get('/admin/notifications', "NotificationController@adminNotif")->name('/admin/notifications');
Route::get('/admin/prof', "ProfController@showProf")->name('/admin/prof');

//admin/calendar
Route::get('/admin/calendar/search',"CalendarController@searchCalendarAdmin")->name('/admin/calendar/search');

//admin/rooms
Route::get('/store',"RoomController@store");
Route::get('/showList',"RoomController@showList")->name('/showList');
Route::post('/update/{id}', "RoomController@update");
Route::get('/edit/{id}', "RoomController@edit");
Route::get('/destroy/{id}', "RoomController@destroy");
Route::get('/searchRoom','RoomController@search')->name('/searchRoom');
Route::get('addRoom', "RoomController@addRoom")->name('addRoom');

//admin/reservations
Route::get('/user/showNames',"ReservationController@showNamesUser");
Route::get('/admin/showNames',"ReservationController@showNamesAdmin");
Route::get('/admin/editR/{id}',"ReservationController@editAdmin");
Route::get('/admin/searchReser','ReservationController@searchAdmin')->name('/admin/searchReser');

//admin/contact
Route::get('/admin/sendedEmail', "MessageController@sendEmail");

//admin/notifications
Route::get('/accept/{id}',"NotificationController@accept");
Route::get('/refuse/{id}',"NotificationController@refuse");

//admin/prof
Route::get('/destroyy/{id}', "ProfController@destroy");
Route::get('/searchProf', "ProfController@search");


////user

//user/navbar
Route::get('calendar', "CalendarController@userCalendar")->name('calendar');
Route::get('/user/showReser',"ReservationController@showReserUser")->name('/user/showReser');
Route::get('/user/email', "MessageController@emailsUser")->name('/user/email');
Route::get('/user/notifications', "NotificationController@userNotif")->name('/user/notifications');

//user/calendar
Route::get('/user/calendar/search',"CalendarController@searchCalendarUser")->name('/user/calendar/search');

//user/reservation
Route::get('/storeR',"ReservationController@store");
Route::get('/user/editR/{id}',"ReservationController@editUser");
Route::get('/updateR/{id}',"ReservationController@update");
Route::get('/destroyR/{id}', "ReservationController@destroy");
Route::get('/user/searchReser','ReservationController@searchUser')->name('/user/searchReser');

//user/contact
Route::get('/user/sendedEmail', "MessageController@sendEmailUser");
