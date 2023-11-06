<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Procesos\ConductoresController;
use App\Http\Controllers\Procesos\MototaxisController;
use App\Http\Controllers\Procesos\MovimientosController;
use App\Http\Controllers\Procesos\ReportesController;
use App\Http\Controllers\Procesos\SociosController;
use App\Http\Controllers\Procesos\UsuariosController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('layouts.layout');
// });

//creamos una ruta para el dashboard
Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::resource('/', DashboardController::class)->names('dashboard');
Route::resource('/conductores', ConductoresController::class)->names('conductores');
Route::resource('/mototaxis', MototaxisController::class)->names('mototaxis');
Route::resource('/reportes', ReportesController::class)->names('reportes');
Route::resource('/usuarios', UsuariosController::class)->names('usuarios');
Route::resource('/socios', SociosController::class)->names('socios');
});

Route::resource('/password/reset', ResetController::class);
Route::resource('/perfil', ProfileController::class)->names('perfil')->middleware('user', 'fireauth');

Route::get('/email/verify', [App\Http\Controllers\Auth\ResetController::class, 'verify_email'])->name('verify')->middleware('fireauth');

Route::get('/mototaxi/getUnidad', [MototaxisController::class, 'getUnidadMax'])->name('mototaxis.getUnidad');