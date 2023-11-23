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
use App\Http\Controllers\Reportes\ReporteriaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
//hacemos una ruta para el index de reporteria
Route::post('/reporte/diario', [DashboardController::class, 'reporteDiarioAction'])->name('reporteria.diario');
Route::post('/reporte/mensual', [DashboardController::class, 'reporteMensualAction'])->name('reporteria.mensual');
});

Route::resource('/password/reset', ResetController::class);
Route::resource('/perfil', ProfileController::class)->names('perfil')->middleware('user', 'fireauth');

Route::get('/email/verify', [App\Http\Controllers\Auth\ResetController::class, 'verify_email'])->name('verify')->middleware('fireauth');

Route::get('/mototaxi/getUnidad', [MototaxisController::class, 'getUnidadMax'])->name('mototaxis.getUnidad');

//Apis dashboard
Route::get('/dashboard/getInfoTurnos', [DashboardController::class, 'getInfoTurnos'])->name('dashboard.getInfoTurnos');
Route::get('/dashboard/getReporteMensual', [DashboardController::class, 'GenerarReporteMensual'])->name('dashboard.getReporteMensual');
Route::get('/dashboard/getUsuariosMasActivos', [DashboardController::class, 'ObtenerUsuariosMasActivos'])->name('dashboard.getUsuariosMasActivos');