<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudIngresoController;

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

Route::get('/', [SolicitudIngresoController::class, 'create'])->name('index');

use App\Http\Controllers\AdminController;

Route::get('/admin', [AdminController::class, 'index']);
Route::prefix('api/admin')->group(function () {
    Route::get('/config', [AdminController::class, 'getConfig']);
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/role', [AdminController::class, 'storeRole']);
    Route::post('/brand', [AdminController::class, 'storeBrand']);
    Route::post('/brand/delete', [AdminController::class, 'deleteBrand']);
    Route::post('/role/delete', [AdminController::class, 'deleteRole']);
    Route::post('/matrix', [AdminController::class, 'saveMatrix']);
    Route::post('/matrix/delete', [AdminController::class, 'deleteMatrix']);
});

Route::post('/solicitud-ingreso', [SolicitudIngresoController::class, 'store'])->name('solicitud-ingreso.store');
Route::get('/Bajas', [SolicitudIngresoController::class, 'bajas'])->name('Bajas');
Route::get('/agregarPermisos', [SolicitudIngresoController::class, 'permisos'])->name('agregarPermisos');

Route::get('/admin-builder', [AdminController::class, 'index'])->name('admin-builder');