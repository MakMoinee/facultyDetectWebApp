<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AdminDetectionsController;
use App\Http\Controllers\AdminDevicesController;
use App\Http\Controllers\AdminFacultyController;
use App\Http\Controllers\CaptureController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\SignOutController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserDasboardController;
use App\Http\Controllers\UserFacultyController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::get("/about", [AboutController::class, 'index']);
Route::get("/contact", [ContactController::class, 'index']);
Route::get("/pricing", [PricingController::class, 'index']);
Route::resource('/login', LoginController::class);
Route::post("/signup", [LoginController::class, 'signup']);
Route::get("/signout", [SignOutController::class, 'index']);
Route::resource('/userdashboard', UserDasboardController::class);
Route::resource("/faculty", UserFacultyController::class);
Route::resource("/admindashboard", AdminDashboard::class);
Route::resource("/adminsono", AdminFacultyController::class);
Route::get("/show/results", [ResultsController::class, 'showResults']);
Route::resource("/results", ResultsController::class);
Route::resource("/adminaccount", AccountsController::class);
Route::resource('/account',UserAccountController::class);
Route::resource('/capture',CaptureController::class);
Route::get('/admin_detections',[AdminDetectionsController::class,'index']);
Route::resource('/admin_devices',AdminDevicesController::class);

