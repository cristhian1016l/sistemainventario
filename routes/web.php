<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

//ADMIN CONTROLLER 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;

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


// ALMACENES
Route::get('/almacenes', [StoreController::class, 'index'])->name('store');

Route::post('/almacenes/obtener-almacenes', [StoreController::class, 'getStores']);
Route::post('/almacenes/eliminar-almacen', [StoreController::class, 'delete']);


// MARCAS
Route::get('/marcas', [BrandController::class, 'index'])->name('brand');

// PROVEEDORES
Route::get('/proveedores', [SupplierController::class, 'index'])->name('supplier');

// PRODUCTOS
Route::get('/productos', [ProductController::class, 'index'])->name('product');