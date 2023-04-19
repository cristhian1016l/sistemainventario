<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

//ADMIN CONTROLLER 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WorkerController;

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
Route::post('/almacenes/agregar-almacen', [StoreController::class, 'insert']);
Route::post('/almacenes/editar-almacen', [StoreController::class, 'edit']);
Route::post('/almacenes/eliminar-almacen', [StoreController::class, 'delete']);

// PROVEEDORES
Route::get('/proveedores', [SupplierController::class, 'index'])->name('supplier');

Route::post('/proveedores/obtener-proveedores', [SupplierController::class, 'getSuppliers']);
Route::post('/proveedores/agregar-proveedor', [SupplierController::class, 'insert']);
Route::post('/proveedores/editar-proveedor', [SupplierController::class, 'edit']);
Route::post('/proveedores/eliminar-proveedor', [SupplierController::class, 'delete']);

// MARCAS
Route::get('/marcas', [BrandController::class, 'index'])->name('brand');

Route::post('/marcas/obtener-marcas', [BrandController::class, 'getBrands']);
Route::post('/marcas/agregar-marca', [BrandController::class, 'insert']);
Route::post('/marcas/editar-marca', [BrandController::class, 'edit']);
Route::post('/marcas/eliminar-marca', [BrandController::class, 'delete']);

// MARCAS
Route::get('/categorias', [CategoryController::class, 'index'])->name('category');

Route::post('/categorias/obtener-categorias', [CategoryController::class, 'getCategories']);
Route::post('/categorias/agregar-categoria', [CategoryController::class, 'insert']);
Route::post('/categorias/editar-categoria', [CategoryController::class, 'edit']);
Route::post('/categorias/eliminar-categoria', [CategoryController::class, 'delete']);

// PRODUCTOS
Route::get('/productos', [ProductController::class, 'index'])->name('product');

Route::post('/productos/obtener-productos', [ProductController::class, 'getProducts']);
Route::post('/productos/obtener-producto/{id}', [ProductController::class, 'getProductById']);
Route::post('/productos/agregar-producto', [ProductController::class, 'insert']);
Route::post('/productos/editar-producto', [ProductController::class, 'edit']);
Route::post('/productos/eliminar-producto', [ProductController::class, 'delete']);

// TRABAJADORES
Route::get('/trabajadores', [WorkerController::class, 'index'])->name('worker');

Route::post('/trabajadores/obtener-trabajadores', [WorkerController::class, 'getWorkers']);
Route::post('/trabajadores/obtener-trabajador/{id}', [WorkerController::class, 'getWorkerById']);
Route::post('/trabajadores/agregar-trabajador', [WorkerController::class, 'insert']);
Route::post('/trabajadores/editar-trabajador', [WorkerController::class, 'edit']);
Route::post('/trabajadores/eliminar-trabajador', [WorkerController::class, 'delete']);