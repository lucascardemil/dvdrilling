<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Reporte;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function index()
    {
        return view('reportes.index');
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

        // Definir las relaciones a cargar con 'with'
        $relations = ['proyecto', 'horometro', 'corona_escareador', 'aditivo', 'herramienta', 'perforacion', 'detalleHora.actividad', 'observacion'];

        // Si el rol es 'usuario', filtrar por el user_id
        if ($rol === 'usuario') {
            $reportes = Reporte::with($relations)->where('user_id', $user->id)->get();
            return response()->json($reportes);
        }

        // Para otros roles, devolver todos los reportes
        $reportes = Reporte::with($relations)->get();
        return response()->json($reportes);
    }



    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'proyecto_id' => 'required|exists:proyectos,id',
            'empresa' => 'required|string|max:255',
            'sondaje' => 'required|string|max:255',
            'fecha' => 'required',
            'sonda' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'horas' => 'required|numeric|min:1|max:9999999999',
            'desde' => 'required|string|max:255',
            'hasta' => 'required|string|max:255',
            'total' => 'required|string|max:255',
            'metros' => 'required|numeric|min:1|max:9999999999',
            'inclinacion' => 'required|numeric|min:1|max:9999999999',
            'rumbo' => 'required|numeric|min:1|max:9999999999',
            'programa' => 'required|string|max:255',
            'diametro' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $fecha = $request->fecha;
        $formattedDate = Carbon::parse($fecha)->format('Y-m-d H:i:s');

        $reporte = Reporte::create([
            'user_id' => $user->id,
            'proyecto_id' => $request->proyecto_id,
            'empresa' => $request->empresa,
            'sondaje' => $request->sondaje,
            'fecha' => $formattedDate,
            'sonda' => $request->sonda,
            'turno' => $request->turno,
            'horas' => $request->horas,
            'desde' => $request->desde,
            'hasta' => $request->hasta,
            'total' => $request->total,
            'metros' => $request->metros,
            'inclinacion' => $request->inclinacion,
            'rumbo' => $request->rumbo,
            'programa' => $request->programa,
            'diametro' => $request->diametro,
            'status' => 0,
        ]);

        return response()->json(['message' => 'Reporte creado exitosamente', 'reporte' => $reporte], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'proyecto_id' => 'required|exists:proyectos,id',
            'empresa' => 'required|string|max:255',
            'sondaje' => 'required|string|max:255',
            'fecha' => 'required',
            'sonda' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'horas' => 'required|string|max:255',
            'desde' => 'required|string|max:255',
            'hasta' => 'required|string|max:255',
            'total' => 'required|string|max:255',
            'metros' => 'required|string|max:255',
            'inclinacion' => 'required|string|max:255',
            'rumbo' => 'required|string|max:255',
            'programa' => 'required|string|max:255',
            'diametro' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        $fecha = $request->fecha;
        $formattedDate = Carbon::parse($fecha)->format('Y-m-d H:i:s');

        $reporte = Reporte::findOrFail($id);
        $reporte->update([
            'proyecto_id' => $request->proyecto_id,
            'empresa' => $request->empresa,
            'sondaje' => $request->sondaje,
            'fecha' => $formattedDate,
            'sonda' => $request->sonda,
            'turno' => $request->turno,
            'horas' => $request->horas,
            'desde' => $request->desde,
            'hasta' => $request->hasta,
            'total' => $request->total,
            'metros' => $request->metros,
            'inclinacion' => $request->inclinacion,
            'rumbo' => $request->rumbo,
            'programa' => $request->programa,
            'diametro' => $request->diametro,
            'status' => 0,
        ]);

        $updatedReporte = Reporte::with('proyecto')->where('id', '=', $reporte['id'])->first();
        return response()->json(['message' => 'Se actualizó correctamente', 'updated_reporte' => $updatedReporte], 201);
    }
}
