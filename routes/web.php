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

Route::get('/user/role', [App\Http\Controllers\HomeController::class, 'getUserRole'])->middleware('auth');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth','permission:proyecto']], function () {
    Route::get('/proyecto', [App\Http\Controllers\ProyectoController::class, 'index'])->name('proyecto.index');
    Route::get('/proyectos/all', [App\Http\Controllers\ProyectoController::class, 'all']);
    Route::get('/proyectos/all-select', [App\Http\Controllers\ProyectoController::class, 'all_select']);
    Route::post('/proyectos/store', [App\Http\Controllers\ProyectoController::class, 'store']);
    Route::put('/proyectos/update/{id}', [App\Http\Controllers\ProyectoController::class, 'update']);
    Route::put('/proyectos/update-status/{id}', [App\Http\Controllers\ProyectoController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:personal']], function () {
    Route::get('/personal', [App\Http\Controllers\PersonalController::class, 'index'])->name('personal.index');
    Route::get('/personals/all', [App\Http\Controllers\PersonalController::class, 'all']);
    Route::get('/personals/buscar-nombre/{nombre?}', [App\Http\Controllers\PersonalController::class, 'buscar_nombre']);
    Route::post('/personals/store', [App\Http\Controllers\PersonalController::class, 'store']);
    Route::put('/personals/update/{id}', [App\Http\Controllers\PersonalController::class, 'update']);
    Route::put('/personals/update-status/{id}', [App\Http\Controllers\PersonalController::class, 'update_status']);

    // Cargos
    Route::get('/cargos/all', [App\Http\Controllers\CargosController::class, 'all']);
    Route::get('/cargos/all-select', [App\Http\Controllers\CargosController::class, 'all_select']);
    Route::post('/cargos/store', [App\Http\Controllers\CargosController::class, 'store']);
    Route::put('/cargos/update/{id}', [App\Http\Controllers\CargosController::class, 'update']);
    Route::put('/cargos/update-status/{id}', [App\Http\Controllers\CargosController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:activos']], function () {
    Route::get('/activos', [App\Http\Controllers\ActivosController::class, 'index'])->name('activos.index');
    Route::get('/activos/all', [App\Http\Controllers\ActivosController::class, 'all']);
    Route::get('/activos/all-select', [App\Http\Controllers\ActivosController::class, 'all_select']);
    Route::post('/activos/store', [App\Http\Controllers\ActivosController::class, 'store']);
    Route::put('/activos/update/{id}', [App\Http\Controllers\ActivosController::class, 'update']);
    Route::put('/activos/update-status/{id}', [App\Http\Controllers\ActivosController::class, 'update_status']);
    Route::post('/activos/update-imagenes', [App\Http\Controllers\ActivosController::class, 'update_imagenes']);
    Route::get('/activos/buscar-nombre/{nombre?}', [App\Http\Controllers\ActivosController::class, 'buscar_nombre']);

    Route::get('/tipo-activos/all', [App\Http\Controllers\TipoActivosController::class, 'all']);
    Route::get('/tipo-activos/all-select', [App\Http\Controllers\TipoActivosController::class, 'all_select']);
    Route::post('/tipo-activos/store', [App\Http\Controllers\TipoActivosController::class, 'store']);
    Route::put('/tipo-activos/update/{id}', [App\Http\Controllers\TipoActivosController::class, 'update']);
    Route::put('/tipo-activos/update-status/{id}', [App\Http\Controllers\TipoActivosController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:recursos']], function () {
    Route::get('/recursos', [App\Http\Controllers\RecursosController::class, 'index'])->name('recursos.index');

    Route::get('/recursos/all-asignar-personal', [App\Http\Controllers\RecursosController::class, 'all_asignar_personal']);
    Route::post('/recursos/store-personal', [App\Http\Controllers\RecursosController::class, 'store_personal']);
    Route::delete('/recursos/delete-personal/{id}', [App\Http\Controllers\RecursosController::class, 'delete_personal']);
    Route::put('/recursos/update-personal/{id}', [App\Http\Controllers\RecursosController::class, 'update_personal']);

    Route::get('/recursos/all-asignar-activos', [App\Http\Controllers\RecursosController::class, 'all_asignar_activos']);
    Route::post('/recursos/store-activo', [App\Http\Controllers\RecursosController::class, 'store_activo']);
    Route::delete('/recursos/delete-activo/{id}', [App\Http\Controllers\RecursosController::class, 'delete_activo']);
    Route::put('/recursos/update-activo/{id}', [App\Http\Controllers\RecursosController::class, 'update_activo']);
});

Route::group(['middleware' => ['auth','permission:actividades']], function () {
    Route::get('/actividades', [App\Http\Controllers\ActividadesController::class, 'index'])->name('actividades.index');

    Route::get('/actividades/all', [App\Http\Controllers\ActividadesController::class, 'all']);
    Route::get('/actividades/all-select', [App\Http\Controllers\ActividadesController::class, 'all_select']);
    Route::post('/actividades/store', [App\Http\Controllers\ActividadesController::class, 'store']);
    Route::put('/actividades/update/{id}', [App\Http\Controllers\ActividadesController::class, 'update']);
    Route::put('/actividades/update-status/{id}', [App\Http\Controllers\ActividadesController::class, 'update_status']);
});

Route::group(['middleware' => ['auth','permission:reportes']], function () {
    Route::get('/reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/all', [App\Http\Controllers\ReporteController::class, 'all']);
    Route::post('/reportes/store', [App\Http\Controllers\ReporteController::class, 'store']);
    Route::put('/reportes/update/{id}', [App\Http\Controllers\ReporteController::class, 'update']);
    Route::post('/reportes/pdf', [App\Http\Controllers\PdfController::class, 'generatePdf']);

    Route::get('/horometros/all/{id}', [App\Http\Controllers\HorometroController::class, 'all']);
    Route::post('/horometros/store', [App\Http\Controllers\HorometroController::class, 'store']);


    Route::get('/coronasEscareadores/all/{id}', [App\Http\Controllers\CoronaEscareadorController::class, 'all']);
    Route::post('/coronasEscareadores/store', [App\Http\Controllers\CoronaEscareadorController::class, 'store']);
    Route::put('/coronasEscareadores/update/{id}', [App\Http\Controllers\CoronaEscareadorController::class, 'update']);
    Route::delete('/coronasEscareadores/delete/{id}', [App\Http\Controllers\CoronaEscareadorController::class, 'delete']);


    Route::get('/aditivos/all/{id}', [App\Http\Controllers\AditivoController::class, 'all']);
    Route::post('/aditivos/store', [App\Http\Controllers\AditivoController::class, 'store']);
    Route::put('/aditivos/update/{id}', [App\Http\Controllers\AditivoController::class, 'update']);
    Route::delete('/aditivos/delete/{id}', [App\Http\Controllers\AditivoController::class, 'delete']);


    Route::get('/herramientas/all/{id}', [App\Http\Controllers\HerramientaController::class, 'all']);
    Route::post('/herramientas/store', [App\Http\Controllers\HerramientaController::class, 'store']);


    Route::get('/perforaciones/all/{id}', [App\Http\Controllers\PerforacionController::class, 'all']);
    Route::post('/perforaciones/store', [App\Http\Controllers\PerforacionController::class, 'store']);
    Route::put('/perforaciones/update/{id}', [App\Http\Controllers\PerforacionController::class, 'update']);
    Route::delete('/perforaciones/delete/{id}', [App\Http\Controllers\PerforacionController::class, 'delete']);

    Route::get('/detalleHoras/all/{id}', [App\Http\Controllers\DetalleHoraController::class, 'all']);
    Route::post('/detalleHoras/store', [App\Http\Controllers\DetalleHoraController::class, 'store']);
    Route::put('/detalleHoras/update/{id}', [App\Http\Controllers\DetalleHoraController::class, 'update']);
    Route::delete('/detalleHoras/delete/{id}', [App\Http\Controllers\DetalleHoraController::class, 'delete']);

    Route::get('/observaciones/all/{id}', [App\Http\Controllers\ObservacionController::class, 'all']);
    Route::post('/observaciones/store', [App\Http\Controllers\ObservacionController::class, 'store']);

});

Route::group(['middleware' => ['auth','permission:checklist']], function () {
    Route::get('/checklist', [App\Http\Controllers\ChecklistController::class, 'index'])->name('checklist.index');

    Route::get('/matrizchecklist/all', [App\Http\Controllers\MatrizChecklistController::class, 'all']);
    Route::post('/matrizchecklist/store_matrizChecklist', [App\Http\Controllers\MatrizChecklistController::class, 'store']);
    Route::put('/matrizchecklist/update_matrizChecklist/{id}', [App\Http\Controllers\MatrizChecklistController::class, 'update']);
    Route::put('/matrizchecklist/update-status/{id}', [App\Http\Controllers\MatrizChecklistController::class, 'update_status']);

    Route::post('/matrizchecklist/store_categoriaMatrizChecklist', [App\Http\Controllers\MatrizChecklistCategoriaController::class, 'store']);
    Route::delete('/matrizchecklist/delete_categoriaMatrizChecklist/{id}', [App\Http\Controllers\MatrizChecklistCategoriaController::class, 'delete']);
    Route::put('/matrizchecklist/update_categoriaMatrizChecklist/{id}', [App\Http\Controllers\MatrizChecklistCategoriaController::class, 'update']);

    Route::post('/matrizchecklist/store_intervencionMatrizChecklist', [App\Http\Controllers\MatrizChecklistIntervencionController::class, 'store']);
    Route::delete('/matrizchecklist/delete_intervencionMatrizChecklist/{id}', [App\Http\Controllers\MatrizChecklistIntervencionController::class, 'delete']);
    Route::put('/matrizchecklist/update_intervencionMatrizChecklist/{id}', [App\Http\Controllers\MatrizChecklistIntervencionController::class, 'update']);

    Route::get('/checklist/all', [App\Http\Controllers\ChecklistController::class, 'all']);
    Route::post('/checklist/store_checklist', [App\Http\Controllers\ChecklistController::class, 'store']);
    Route::put('/checklist/update_checklist/{id}', [App\Http\Controllers\ChecklistController::class, 'update']);
    Route::put('/checklist/update-status/{id}', [App\Http\Controllers\ChecklistController::class, 'update_status']);
    Route::post('/checklist/store_completarChecklist', [App\Http\Controllers\ChecklistController::class, 'store_completar_checklist']);

    Route::post('/checklist/store_categoriaChecklist', [App\Http\Controllers\ChecklistCategoriaController::class, 'store']);
    Route::put('/checklist/update_categoriaChecklist/{id}', [App\Http\Controllers\ChecklistCategoriaController::class, 'update']);
    Route::delete('/checklist/delete_categoriaChecklist/{id}', [App\Http\Controllers\ChecklistCategoriaController::class, 'delete']);
    
    Route::get('/checklist/intervenciones/{id}', [App\Http\Controllers\ChecklistIntervencionController::class, 'all']);
    Route::post('/checklist/store_intervencionChecklist', [App\Http\Controllers\ChecklistIntervencionController::class, 'store']);
    Route::put('/checklist/update_intervencionChecklist/{id}', [App\Http\Controllers\ChecklistIntervencionController::class, 'update']);
    Route::delete('/checklist/delete_intervencionChecklist/{id}', [App\Http\Controllers\ChecklistIntervencionController::class, 'delete']);

    Route::post('/checklist/store_observacionChecklist', [App\Http\Controllers\ChecklistObservacionController::class, 'store']);
    Route::delete('/checklist/delete_observacionChecklist/{id}', [App\Http\Controllers\ChecklistObservacionController::class, 'delete']);
});

Route::group(['middleware' => ['auth','permission:usuarios']], function () {
    Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/all', [App\Http\Controllers\UsuariosController::class, 'all']);
    Route::post('/usuarios/store', [App\Http\Controllers\UsuariosController::class, 'store']);
    Route::put('/usuarios/update/{id}', [App\Http\Controllers\UsuariosController::class, 'update']);
    Route::put('/usuarios/update-status/{id}', [App\Http\Controllers\UsuariosController::class, 'update_status']);
    Route::put('/usuarios/update-password/{id}', [App\Http\Controllers\UsuariosController::class, 'update_password']);
});

Route::group(['middleware' => ['auth','permission:roles']], function () {
    Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/all', [App\Http\Controllers\RolesController::class, 'all']);
    Route::post('/roles/store', [App\Http\Controllers\RolesController::class, 'store']);
    Route::put('/roles/update/{id}', [App\Http\Controllers\RolesController::class, 'update']);
    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index']);
});

Route::get('/storage-link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});
