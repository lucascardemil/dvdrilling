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
    return view('home');
});

Route::group(['middleware' => 'web'], function () {
    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::group(['middleware' => ['auth','permission:proyecto']], function () {
    Route::get('/proyecto', [App\Http\Controllers\ProyectoController::class, 'index'])->name('proyecto.index');
    Route::get('/api/proyectos/all', [App\Http\Controllers\ProyectoController::class, 'all']);
    Route::get('/api/proyectos/all-select', [App\Http\Controllers\ProyectoController::class, 'all_select']);
    Route::post('/api/proyectos/store', [App\Http\Controllers\ProyectoController::class, 'store']);
    Route::put('/api/proyectos/update/{id}', [App\Http\Controllers\ProyectoController::class, 'update']);
    Route::put('/api/proyectos/update-status/{id}', [App\Http\Controllers\ProyectoController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:personal']], function () {
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

Route::group(['middleware' => ['auth','permission:activos']], function () {
    Route::get('/activos', [App\Http\Controllers\ActivosController::class, 'index'])->name('activos.index');
    Route::get('/api/activos/all', [App\Http\Controllers\ActivosController::class, 'all']);
    Route::get('/api/activos/all-select', [App\Http\Controllers\ActivosController::class, 'all_select']);
    Route::post('/api/activos/store', [App\Http\Controllers\ActivosController::class, 'store']);
    Route::put('/api/activos/update/{id}', [App\Http\Controllers\ActivosController::class, 'update']);
    Route::put('/api/activos/update-status/{id}', [App\Http\Controllers\ActivosController::class, 'update_status']);
    Route::post('/api/activos/update-imagenes', [App\Http\Controllers\ActivosController::class, 'update_imagenes']);
    Route::get('/api/activos/buscar-nombre/{nombre?}', [App\Http\Controllers\ActivosController::class, 'buscar_nombre']);

    Route::get('/api/tipo-activos/all', [App\Http\Controllers\TipoActivosController::class, 'all']);
    Route::get('/api/tipo-activos/all-select', [App\Http\Controllers\TipoActivosController::class, 'all_select']);
    Route::post('/api/tipo-activos/store', [App\Http\Controllers\TipoActivosController::class, 'store']);
    Route::put('/api/tipo-activos/update/{id}', [App\Http\Controllers\TipoActivosController::class, 'update']);
    Route::put('/api/tipo-activos/update-status/{id}', [App\Http\Controllers\TipoActivosController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:recursos']], function () {
    Route::get('/recursos', [App\Http\Controllers\RecursosController::class, 'index'])->name('recursos.index');

    Route::get('/api/recursos/all-asignar-personal', [App\Http\Controllers\RecursosController::class, 'all_asignar_personal']);
    Route::post('/api/recursos/store-personal', [App\Http\Controllers\RecursosController::class, 'store_personal']);
    Route::delete('/api/recursos/delete-personal/{id}', [App\Http\Controllers\RecursosController::class, 'delete_personal']);
    Route::put('/api/recursos/update-personal/{id}', [App\Http\Controllers\RecursosController::class, 'update_personal']);

    Route::get('/api/recursos/all-asignar-activos', [App\Http\Controllers\RecursosController::class, 'all_asignar_activos']);
    Route::post('/api/recursos/store-activo', [App\Http\Controllers\RecursosController::class, 'store_activo']);
    Route::delete('/api/recursos/delete-activo/{id}', [App\Http\Controllers\RecursosController::class, 'delete_activo']);
    Route::put('/api/recursos/update-activo/{id}', [App\Http\Controllers\RecursosController::class, 'update_activo']);
});

Route::group(['middleware' => ['auth','permission:actividades']], function () {
    Route::get('/actividades', [App\Http\Controllers\ActividadesController::class, 'index'])->name('actividades.index');

    Route::get('/api/actividades/all', [App\Http\Controllers\ActividadesController::class, 'all']);
    Route::get('/api/actividades/all-select', [App\Http\Controllers\ActividadesController::class, 'all_select']);
    Route::post('/api/actividades/store', [App\Http\Controllers\ActividadesController::class, 'store']);
    Route::put('/api/actividades/update/{id}', [App\Http\Controllers\ActividadesController::class, 'update']);
    Route::put('/api/actividades/update-status/{id}', [App\Http\Controllers\ActividadesController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:reportes']], function () {
    Route::get('/reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/api/reportes/all', [App\Http\Controllers\ReporteController::class, 'all']);
    Route::post('/api/reportes/store', [App\Http\Controllers\ReporteController::class, 'store']);
    Route::put('/api/reportes/update/{id}', [App\Http\Controllers\ReporteController::class, 'update']);
    Route::post('/api/reportes/pdf', [App\Http\Controllers\PdfController::class, 'generatePdf']);

    Route::get('/api/horometros/all/{id}', [App\Http\Controllers\HorometroController::class, 'all']);
    Route::post('/api/horometros/store', [App\Http\Controllers\HorometroController::class, 'store']);


    Route::get('/api/coronasEscareadores/all/{id}', [App\Http\Controllers\CoronaEscareadorController::class, 'all']);
    Route::post('/api/coronasEscareadores/store', [App\Http\Controllers\CoronaEscareadorController::class, 'store']);
    Route::put('/api/coronasEscareadores/update/{id}', [App\Http\Controllers\CoronaEscareadorController::class, 'update']);
    Route::delete('/api/coronasEscareadores/delete/{id}', [App\Http\Controllers\CoronaEscareadorController::class, 'delete']);


    Route::get('/api/aditivos/all/{id}', [App\Http\Controllers\AditivoController::class, 'all']);
    Route::post('/api/aditivos/store', [App\Http\Controllers\AditivoController::class, 'store']);
    Route::put('/api/aditivos/update/{id}', [App\Http\Controllers\AditivoController::class, 'update']);
    Route::delete('/api/aditivos/delete/{id}', [App\Http\Controllers\AditivoController::class, 'delete']);


    Route::get('/api/herramientas/all/{id}', [App\Http\Controllers\HerramientaController::class, 'all']);
    Route::post('/api/herramientas/store', [App\Http\Controllers\HerramientaController::class, 'store']);


    Route::get('/api/perforaciones/all/{id}', [App\Http\Controllers\PerforacionController::class, 'all']);
    Route::post('/api/perforaciones/store', [App\Http\Controllers\PerforacionController::class, 'store']);
    Route::put('/api/perforaciones/update/{id}', [App\Http\Controllers\PerforacionController::class, 'update']);
    Route::delete('/api/perforaciones/delete/{id}', [App\Http\Controllers\PerforacionController::class, 'delete']);

    Route::get('/api/detalleHoras/all/{id}', [App\Http\Controllers\DetalleHoraController::class, 'all']);
    Route::post('/api/detalleHoras/store', [App\Http\Controllers\DetalleHoraController::class, 'store']);
    Route::put('/api/detalleHoras/update/{id}', [App\Http\Controllers\DetalleHoraController::class, 'update']);
    Route::delete('/api/detalleHoras/delete/{id}', [App\Http\Controllers\DetalleHoraController::class, 'delete']);

    Route::get('/api/observaciones/all/{id}', [App\Http\Controllers\ObservacionController::class, 'all']);
    Route::post('/api/observaciones/store', [App\Http\Controllers\ObservacionController::class, 'store']);

});

Route::group(['middleware' => ['auth','permission:checklist']], function () {
    Route::get('/checklist', [App\Http\Controllers\ChecklistController::class, 'index'])->name('checklist.index');

    Route::get('/api/matrizchecklist/all', [App\Http\Controllers\MatrizChecklistController::class, 'all']);
    Route::post('/api/matrizchecklist/store_matrizChecklist', [App\Http\Controllers\MatrizChecklistController::class, 'store']);
    Route::put('/api/matrizchecklist/update_matrizChecklist/{id}', [App\Http\Controllers\MatrizChecklistController::class, 'update']);
    Route::put('/api/matrizchecklist/update-status/{id}', [App\Http\Controllers\MatrizChecklistController::class, 'update_status']);

    Route::post('/api/matrizchecklist/store_categoriaMatrizChecklist', [App\Http\Controllers\MatrizCategoriaChecklistController::class, 'store']);
    Route::delete('/api/matrizchecklist/delete_categoriaMatrizChecklist/{id}', [App\Http\Controllers\MatrizCategoriaChecklistController::class, 'delete']);
    Route::put('/api/matrizchecklist/update_categoriaMatrizChecklist/{id}', [App\Http\Controllers\MatrizCategoriaChecklistController::class, 'update']);

    Route::post('/api/matrizchecklist/store_intervencionMatrizChecklist', [App\Http\Controllers\MatrizIntervencionChecklistController::class, 'store']);
    Route::delete('/api/matrizchecklist/delete_intervencionMatrizChecklist/{id}', [App\Http\Controllers\MatrizIntervencionChecklistController::class, 'delete']);
    Route::put('/api/matrizchecklist/update_intervencionMatrizChecklist/{id}', [App\Http\Controllers\MatrizIntervencionChecklistController::class, 'update']);

    Route::get('/api/checklist/all', [App\Http\Controllers\ChecklistController::class, 'all']);
    Route::post('/api/checklist/store_checklist', [App\Http\Controllers\ChecklistController::class, 'store']);
    Route::put('/api/checklist/update_checklist/{id}', [App\Http\Controllers\ChecklistController::class, 'update']);
    Route::put('/api/checklist/update-status/{id}', [App\Http\Controllers\ChecklistController::class, 'update_status']);

    Route::get('/api/checklist/intervenciones/{id}', [App\Http\Controllers\IntervencionChecklistController::class, 'all']);
    Route::post('/api/checklist/store_intervencionChecklist', [App\Http\Controllers\IntervencionChecklistController::class, 'store']);
});

Route::group(['middleware' => ['auth','permission:usuarios']], function () {
    Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/api/usuarios/all', [App\Http\Controllers\UsuariosController::class, 'all']);
    Route::post('/api/usuarios/store', [App\Http\Controllers\UsuariosController::class, 'store']);
    Route::put('/api/usuarios/update/{id}', [App\Http\Controllers\UsuariosController::class, 'update']);
    Route::put('/api/usuarios/update-status/{id}', [App\Http\Controllers\UsuariosController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:roles']], function () {
    Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('roles.index');
    Route::get('/api/roles/all', [App\Http\Controllers\RolesController::class, 'all']);
    Route::post('/api/roles/store', [App\Http\Controllers\RolesController::class, 'store']);
    Route::put('/api/roles/update/{id}', [App\Http\Controllers\RolesController::class, 'update']);
    Route::get('/api/permissions', [App\Http\Controllers\PermissionController::class, 'index']);
});
