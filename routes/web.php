<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'web'], function () {
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['permission:proyecto']], function () {
    Route::get('/proyecto', [App\Http\Controllers\ProyectoController::class, 'index'])->name('proyecto.index');
    Route::get('/api/proyectos/all', [App\Http\Controllers\ProyectoController::class, 'all']);
    Route::get('/api/proyectos/all-select', [App\Http\Controllers\ProyectoController::class, 'all_select']);
    Route::post('/api/proyectos/store', [App\Http\Controllers\ProyectoController::class, 'store']);
    Route::put('/api/proyectos/update/{id}', [App\Http\Controllers\ProyectoController::class, 'update']);
    Route::put('/api/proyectos/update-status/{id}', [App\Http\Controllers\ProyectoController::class, 'update_status']);
});

Route::group(['middleware' => ['permission:personal']], function () {
    Route::get('/personal', [App\Http\Controllers\PersonalController::class, 'index'])->name('personal.index');
    Route::get('/api/personals/all', [App\Http\Controllers\PersonalController::class, 'all']);
    Route::get('/api/personals/buscar-nombre/{nombre?}', [App\Http\Controllers\PersonalController::class, 'buscar_nombre']);
    Route::post('/api/personals/store', [App\Http\Controllers\PersonalController::class, 'store']);
    Route::put('/api/personals/update/{id}', [App\Http\Controllers\PersonalController::class, 'update']);
    Route::put('/api/personals/update-status/{id}', [App\Http\Controllers\PersonalController::class, 'update_status']);

    // Cargos
    Route::get('/api/cargos/all', [App\Http\Controllers\CargosController::class, 'all']);
    Route::get('/api/cargos/all-select', [App\Http\Controllers\CargosController::class, 'all_select']);
    Route::post('/api/cargos/store', [App\Http\Controllers\CargosController::class, 'store']);
    Route::put('/api/cargos/update/{id}', [App\Http\Controllers\CargosController::class, 'update']);
    Route::put('/api/cargos/update-status/{id}', [App\Http\Controllers\CargosController::class, 'update_status']);
});

Route::group(['middleware' => ['permission:activos']], function () {
    Route::get('/activos', [App\Http\Controllers\ActivosController::class, 'index'])->name('activos.index');
    Route::get('/api/activos/all', [App\Http\Controllers\ActivosController::class, 'all']);
    Route::get('/api/activos/all-select', [App\Http\Controllers\ActivosController::class, 'all_select']);
    Route::post('/api/activos/store', [App\Http\Controllers\ActivosController::class, 'store']);
    Route::put('/api/activos/update/{id}', [App\Http\Controllers\ActivosController::class, 'update']);
    Route::put('/api/activos/update-status/{id}', [App\Http\Controllers\ActivosController::class, 'update_status']);
    Route::post('/api/activos/update-imagenes', [App\Http\Controllers\ActivosController::class, 'update_imagenes']);

    Route::get('/api/tipo-activos/all', [App\Http\Controllers\TipoActivosController::class, 'all']);
    Route::get('/api/tipo-activos/all-select', [App\Http\Controllers\TipoActivosController::class, 'all_select']);
    Route::post('/api/tipo-activos/store', [App\Http\Controllers\TipoActivosController::class, 'store']);
    Route::put('/api/tipo-activos/update/{id}', [App\Http\Controllers\TipoActivosController::class, 'update']);
    Route::put('/api/tipo-activos/update-status/{id}', [App\Http\Controllers\TipoActivosController::class, 'update_status']);
});

Route::group(['middleware' => ['permission:recursos']], function () {
    Route::get('/recursos', [App\Http\Controllers\RecursosController::class, 'index'])->name('recursos.index');
    Route::get('/api/recursos/all_asignar_personal', [App\Http\Controllers\RecursosController::class, 'all_asignar_personal']);
    Route::post('/api/recursos/store_personal', [App\Http\Controllers\RecursosController::class, 'store_personal']);
});

Route::group(['middleware' => ['permission:actividades']], function () {
    Route::get('/actividades', [App\Http\Controllers\ActividadesController::class, 'index'])->name('actividades.index');

    Route::get('/api/actividades/all', [App\Http\Controllers\ActividadesController::class, 'all']);
    Route::get('/api/actividades/all-select', [App\Http\Controllers\ActividadesController::class, 'all_select']);
    Route::post('/api/actividades/store', [App\Http\Controllers\ActividadesController::class, 'store']);
    Route::put('/api/actividades/update/{id}', [App\Http\Controllers\ActividadesController::class, 'update']);
    Route::put('/api/actividades/update-status/{id}', [App\Http\Controllers\ActividadesController::class, 'update_status']);
});

Route::group(['middleware' => ['permission:reporte']], function () {
    Route::get('/reporte', [App\Http\Controllers\ReporteController::class, 'index'])->name('reporte.index');
});

Route::group(['middleware' => ['permission:checklist']], function () {
    Route::get('/checklist', [App\Http\Controllers\ChecklistController::class, 'index'])->name('checklist.index');
});

Route::group(['middleware' => ['permission:usuarios']], function () {
    Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/api/usuarios/all', [App\Http\Controllers\UsuariosController::class, 'all']);
    Route::post('/api/usuarios/store', [App\Http\Controllers\UsuariosController::class, 'store']);
    Route::put('/api/usuarios/update/{id}', [App\Http\Controllers\UsuariosController::class, 'update']);
    Route::put('/api/usuarios/update-status/{id}', [App\Http\Controllers\UsuariosController::class, 'update_status']);
});

Route::group(['middleware' => ['permission:roles']], function () {
    Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('roles.index');
    Route::get('/api/roles/all', [App\Http\Controllers\RolesController::class, 'all']);
    Route::post('/api/roles/store', [App\Http\Controllers\RolesController::class, 'store']);
    Route::put('/api/roles/update/{id}', [App\Http\Controllers\RolesController::class, 'update']);
    Route::get('/api/permissions', [App\Http\Controllers\PermissionController::class, 'index']);
});
