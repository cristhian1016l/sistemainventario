<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

use App\Models\User;
use App\Models\Supplier; //DELETE
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

//ADMIN CONTROLLER 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\FlashdriveController;

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

Route::group(['middleware' => 'isAdmin'], function (){

    // ALMACENES
    Route::get('/almacenes', [StoreController::class, 'index'])->name('store');

    Route::post('/almacenes/obtener-almacenes', [StoreController::class, 'getStores']);
    Route::post('/almacenes/obtener-almacen/{id}', [StoreController::class, 'getStoreById']);
    Route::post('/almacenes/agregar-almacen', [StoreController::class, 'insert']);
    Route::post('/almacenes/editar-almacen', [StoreController::class, 'edit']);
    Route::post('/almacenes/eliminar-almacen', [StoreController::class, 'delete']);
    // FIN ALMACENES

    // PROVEEDORES
    Route::get('/proveedores', [SupplierController::class, 'index'])->name('supplier');

    Route::post('/proveedores/obtener-proveedores', [SupplierController::class, 'getSuppliers']);
    Route::post('/proveedores/agregar-proveedor', [SupplierController::class, 'insert']);
    Route::post('/proveedores/editar-proveedor', [SupplierController::class, 'edit']);
    Route::post('/proveedores/eliminar-proveedor', [SupplierController::class, 'delete']);
    // FIN PROVEEDORES

    // MARCAS
    Route::get('/marcas', [BrandController::class, 'index'])->name('brand');

    Route::post('/marcas/obtener-marcas', [BrandController::class, 'getBrands']);
    Route::post('/marcas/agregar-marca', [BrandController::class, 'insert']);
    Route::post('/marcas/editar-marca', [BrandController::class, 'edit']);
    Route::post('/marcas/eliminar-marca', [BrandController::class, 'delete']);
    // FIN MARCAS

    // CATEGORÍAS
    Route::get('/categorias', [CategoryController::class, 'index'])->name('category');

    Route::post('/categorias/obtener-categorias', [CategoryController::class, 'getCategories']);
    Route::post('/categorias/agregar-categoria', [CategoryController::class, 'insert']);
    Route::post('/categorias/editar-categoria', [CategoryController::class, 'edit']);
    Route::post('/categorias/eliminar-categoria', [CategoryController::class, 'delete']);
    // FIN CATEGORÍAS

    // PRODUCTOS
    Route::get('/productos', [ProductController::class, 'index'])->name('product');

    Route::post('/productos/obtener-productos', [ProductController::class, 'getProducts']);
    Route::post('/productos/obtener-producto/{id}', [ProductController::class, 'getProductById']);
    Route::post('/productos/obtener-productos-categoria', [ProductController::class, 'gerProductsByCategory']);
    Route::post('/productos/agregar-producto', [ProductController::class, 'insert']);
    Route::post('/productos/editar-producto', [ProductController::class, 'edit']);
    Route::post('/productos/eliminar-producto', [ProductController::class, 'delete']);

    Route::get('/productos/reporte-productos', [ProductController::class, 'productsReport'])->name('product.reports');


    // FIN PRODUCTOS

    // TRABAJADORES
    Route::get('/trabajadores', [WorkerController::class, 'index'])->name('worker');

    Route::post('/trabajadores/obtener-trabajadores', [WorkerController::class, 'getWorkers']);
    Route::post('/trabajadores/obtener-trabajador/{id}', [WorkerController::class, 'getWorkerById']);
    Route::post('/trabajadores/agregar-trabajador', [WorkerController::class, 'insert']);
    Route::post('/trabajadores/editar-trabajador', [WorkerController::class, 'edit']);
    Route::post('/trabajadores/eliminar-trabajador', [WorkerController::class, 'delete']);

    Route::post('/trabajadores/obtener-productos-asignados', [WorkerController::class, 'getAssignedProducts']);
    Route::post('/trabajadores/agregar-producto-asignado', [WorkerController::class, 'assignProductsToWorker']);
    Route::post('/trabajadores/eliminar-producto-asignado', [WorkerController::class, 'deleteProductAssigned']);

    Route::get('/trabajadores/declaracion-jurada-pdf/{area}', [WorkerController::class, 'swornDeclarationPDF'])->name('worker.sworndeclarationpdf');
    Route::get('/trabajadores/listado-por-cargo/{cod_type}', [WorkerController::class, 'listingByPositionPDF'])->name('worker.listingByPosition');

    // FIN TRABAJADORES

    // SOLICITUDES
    Route::get('/solicitudes', [RequestController::class, 'index'])->name('request');
    Route::get('/solicitudes/crear-solicitud', [RequestController::class, 'create'])->name('request.create');

    Route::post('/solicitudes/obtener-solicitudes', [RequestController::class, 'getRequests']);
    Route::post('/solicitudes/obtener-solicitud/{id}', [RequestController::class, 'getRequestById']);
    Route::post('/solicitudes/agregar-solicitud', [RequestController::class, 'insert']);
    Route::post('/solicitudes/editar-solicitud', [RequestController::class, 'edit']);
    Route::post('/solicitudes/eliminar-solicitud', [RequestController::class, 'delete']);
    Route::post('/solicitudes/cambiar-estado', [RequestController::class, 'changeStatus']);

    Route::get('/solicitudes/solicitud-pdf/{cod_request}', [RequestController::class, 'request_report'])->name('request.request_report');

    // FIN SOLICITUDES

    // AREAS
    Route::get('/equipos', [TeamController::class, 'index'])->name('team');

    Route::post('/equipos/obtener-equipos', [TeamController::class, 'getTeams']);
    Route::post('/equipos/agregar-equipo', [TeamController::class, 'insert']);
    // Route::post('/equipos/editar-equipo', [TeamController::class, 'edit']);
    // Route::post('/equipos/eliminar-equipo', [TeamController::class, 'delete']);
    // FIN AREAS

    // MEMORIAS
    Route::get('/memorias', [FlashdriveController::class, 'index'])->name('flashdrive');
    Route::post('/memorias/obtener-memorias', [FlashdriveController::class, 'getFlashdrives']);
    Route::post('/memorias/agregar-memoria', [FlashdriveController::class, 'insert']);    
    // FIN MEMORIAS
});

Route::get('/create', function(){

    // User::create([
    //     'email' => 'juanup@ponceproducciones.com',
    //     'password' => bcrypt('123456'),
    //     'active' => 1
    // ]);

    // Role::create(['name' => 'admin']);
    // Role::create(['name' => 'lidercdp']);
    // Role::create(['name' => 'administrador']);
    // Role::create(['name' => 'mentor']);
    // Role::create(['name' => 'tesorero']);
    // User::find(1)->assignRole('admin');
    // User::find(2)->assignRole('liderred');
    // User::find(3)->assignRole('liderred');
    // User::find(4)->assignRole('liderred');
    // User::find(5)->assignRole('lidercdp');
    // User::find(1)->assignRole('mentor');
    // User::find(6)->assignRole('tesorero');
});

// Route::get('/create-user', function(){

//     Role::create(['name' => 'admin']);

//     User::create([
//         'email' => 'juanup@ponceproducciones.com',
//         'password' => bcrypt('123456'),
//         'active' => '1'
//     ]);

//     User::find(1)->assignRole('admin');
// });

// Route::get('/create-supplier', function(){

//     $supplier = new Supplier();    
//     $supplier->bussiness_name = 'GRUPO COMPUTEL';
//     $supplier->ruc = '20608449320';
//     $supplier->address = 'AV. GARCILAZO DE LA VEGA NRO. 1348 TDA 1A-179 (CENTRO COMERCIAL CIBERPLAZA) LIMA-LIMA-LIMA';
//     $supplier->phone = '+51 951803761';
//     $supplier->landline = '01 0000000';
//     $supplier->save();
// });

// Route::get('/create-document', function(){

//     DB::table('document_type')->insert(
//         array(
//             'document_type' => 'DNI'
//         )
//     );
    
//     DB::table('document_type')->insert(
//         array(
//             'document_type' => 'CARNET DE EXTRANJERÍA'
//         )
//     );
    
// });

// Route::get('/create-worker-type', function(){

//     DB::table('worker_type')->insert(
//         array(
//             'name' => 'EDITOR'
//         )
//     );
    
//     DB::table('worker_type')->insert(
//         array(
//             'name' => 'PRODUCTOR'
//         )
//     );

//     DB::table('worker_type')->insert(
//         array(
//             'name' => 'OTRO CARGO'
//         )
//     );
    
// });

// Route::get('/create-area', function(){

//     DB::table('areas')->insert(
//         array(
//             'name' => 'EDICIÓN'
//         )
//     );
    
//     DB::table('areas')->insert(
//         array(
//             'name' => 'DISTRIBUCIÓN'
//         )
//     );

//     DB::table('areas')->insert(
//         array(
//             'name' => 'CAMPO'
//         )
//     );
    
// });

// Route::get('/create-companies', function(){

//     DB::table('companies')->insert(
//         array(
//             'name' => '*** SIN EMPRESA ***'
//         )
//     );

//     DB::table('companies')->insert(
//         array(
//             'name' => 'PRODUCCIONES 89'
//         )
//     );
    
//     DB::table('companies')->insert(
//         array(
//             'name' => 'UNSIHUAY RECORDS'
//         )
//     );

//     DB::table('companies')->insert(
//         array(
//             'name' => 'PONCE PRODUCCIONES'
//         )
//     );
    
// });