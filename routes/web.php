<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

//ADMIN CONTROLLER 
use App\Http\Controllers\Admin\DashboardController;

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

Route::get('/', [LoginController::class, 'show_login'])->name('show_login');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout'); //sólo para invitados!

Route::get('/panel', [DashboardController::class, 'index'])->name('panel');
