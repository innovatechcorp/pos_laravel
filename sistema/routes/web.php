<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedoreController;

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

Route::get('/', function () {
    return view('template');
});
// Route::get('/presentaciones', function () {
//     return view('presentacion.index');
// });
Route::resources([
    'categorias'=>categoriaController::class,
    'marcas'=>marcaController::class,
    'presentaciones'=>presentacionController::class,
    'productos'=>productoController::class,
    'clientes'=>clienteController::class,
    'proveedores'=>proveedoreController::class

]);

Route::view('/panel','panel.index')->name('panel');


Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});
