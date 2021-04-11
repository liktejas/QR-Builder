<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\MailController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\QRController;

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

// Route::get('/sendemail', [MailController::class, 'sendEmail']);
Route::view('/','login');
Route::post('/login',[UsersController::class, 'login']);
Route::get('/dashboard', [UsersController::class, 'dashboard']);
Route::get('/logout',[UsersController::class, 'logout']);
Route::get('/users',[UsersController::class, 'users']);
Route::post('/add_user', [UsersController::class, 'add_user']);
Route::get('/changeStatus', [UsersController::class, 'changeStatus']);
Route::post('/editUsers', [UsersController::class, 'editUsers']);
Route::get('/delete_user/{id}',[UsersController::class, 'delete_user']);
Route::post('/add_qr_code', [QRController::class, 'add_qr_code']);
Route::get('/qrchangeStatus', [QRController::class, 'qrchangeStatus']);
Route::post('/edit_qr_code', [QRController::class, 'edit_qr_code']);
Route::get('/delete_qr/{id}', [QRController::class, 'delete_qr']);
Route::get('/statistics/{id}', [QRController::class, 'statistics']);
Route::get('/qrReport/{id}', [QRController::class, 'qrReport']);
Route::get('/detailed_report/{id}', [QRController::class, 'detailed_report']);
Route::get('/detection/{id}', [QRController::class, 'detection']);