<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\compraController;
use App\Http\Controllers\ventaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;



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

// Route::get('/presentaciones', function () {
//     return view('presentacion.index');
// });
Route::get('/',[homeController::class,'index'])->name('panel');
Route::resources([
    'categorias'=>categoriaController::class,
    'marcas'=>marcaController::class,
    'presentaciones'=>presentacionController::class,
    'productos'=>productoController::class,
    'clientes'=>clienteController::class,
    'proveedores'=>proveedoreController::class,
    'compras'=>compraController::class,
    'ventas'=>ventaController::class,
    'users'=>userController::class,
    'roles'=>roleController::class,

]);

// Route::view('/panel','panel.index')->name('panel');


Route::get('/login',[loginController::class,'index'])->name('login');
Route::post('/login',[loginController::class,'login']);
Route::get('/logout',[logoutController::class,'logout'])->name('logout');

Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});
