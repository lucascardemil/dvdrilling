<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ChecklistVehiculo;
use Illuminate\Support\Facades\Auth;


class ChecklistVehiculoController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:checklist');
    }

    public function index()
    {
        return view('checklist.index');
    }

    public function all()
    {
        // Verificar si el usuario está autenticado
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Obtener el rol del usuario autenticado
        $rol = $user->getRoleNames()->first(); // Asumiendo que usas spatie/laravel-permission

        // Si el rol es 'usuario', filtrar por el user_id
        if ($rol === 'usuario') {
            $reportes = ChecklistVehiculo::where('user_id', $user->id)->get();
            return response()->json($reportes);
        }

        // Para otros roles, devolver todos los reportes
        $reportes = ChecklistVehiculo::get();
        return response()->json($reportes);
    }
}