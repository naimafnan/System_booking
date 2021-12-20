<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Homepagecontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CustomerListTodayController;
use App\Http\Controllers\listAllCustomerController;
use App\Http\Controllers\BookingDetailsController;
use App\Http\Controllers\ListCustomerExpiredController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\listAllCarController;
use App\Http\Controllers\listAllRoomController;
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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//route for admin & doctor
Route::get('/dashboard',[\App\Http\Controllers\dashboardController::class,'index']);

//display list
Route::resource('/', HomepageController::class);
Route::get('/', [HomepageController::class,'index']);
Route::get('/search', [HomepageController::class,'search']);

//dependant dropdown
Route::get('/getProvider',[Homepagecontroller::class,'fetch']);
Route::get('/getCompany',[Homepagecontroller::class,'fetchCompany']);

//user choose specific booking
Route::get('/booking/{providerId}/{id}',[HomepageController::class,'show'])->name('booking');

//parse json to get time available
Route::post('/getTime',[HomepageController::class,'getTime'])->name('getTime');
Route::post('/getTimeCar',[HomepageController::class,'getTimeCar'])->name('getTimeCar');

//store appointment
Route::post('/booking/appointment',[HomepageController::class,'store'])->name('userAppointment');
Route::post('/carBooking',[Homepagecontroller::class,'carBooking'])->name('carBooking');
Route::post('/roomBooking',[Homepagecontroller::class,'roomBooking'])->name('roomBooking');

//update profile user
Route::resource('/user-profile',ProfileController::class);
Route::post('/user-profile-update',[ProfileController::class,'update']);

//schedule timing
Route::resource('/schedule', ScheduleController::class);
//update schedule
Route::post('/schedule-update',[ScheduleController::class,'update'])->name('schedule');

//patientlist for today
Route::resource('/patientToday',CustomerListTodayController::class);
Route::post('/patientToday-update',[CustomerListTodayController::class,'update']);
Route::post('/patientToday-cancel',[CustomerListTodayController::class,'cancelBooking']);

//allcustomer
Route::resource('/allPatient',listAllCustomerController::class);
Route::post('/allPatient-update',[listAllCustomerController::class,'update']);
Route::post('/allPatient-cancel',[listAllCustomerController::class,'cancelBooking']);

//expired Customer
Route::resource('/expired',ListCustomerExpiredController::class);

//booking details
Route::get('/myBooking',[BookingDetailsController::class,'index']);
Route::get('/BookingDetails/{appointmentsId}',[BookingDetailsController::class,'BookingDetails']);
Route::post('/booking-cancel',[BookingDetailsController::class,'update']);

//admin create car provider
Route::resource('/create-Car',ProviderController::class);
Route::post('/create-Car',[ProviderController::class,'store'])->name('createCar');

//admin create meeting room provider
Route::get('/meetingRoom-edit/{$id}',[ProviderController::class,'roomEdit']);
Route::get('/create-MeetingRoom',[ProviderController::class,'create2'])->name('MeetingRoom');
Route::post('/create-MeetingRoom',[ProviderController::class,'store2'])->name('createMeetingRoom');


//listing all car
Route::resource('/allCar',listAllCarController::class);
Route::post('/allCar',listAllCarController::class,'update');

//listing Meeting room
Route::resource('/allMeetingRoom',listAllRoomController::class);
Route::post('/allMeetingRoom',[listAllRoomController::class,'update']);
// Route::post('/allMeetingRoom/{$id}',[listAllRoomController::class, 'delete']);
// Route::put('/MeetingRoom/{id}',[listAllRoomController::class,'update']);