<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Perforacion;

class PerforacionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function all($id)
    {
        $perforacion = Perforacion::where('reporte_id', $id)->get();
        return response()->json($perforacion);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'reporte_id' => 'required|exists:reportes,id',
            'desde' => 'required|not_in:0',
            'hasta' => 'required|not_in:0',
            'perforado' => 'required|not_in:0',
            'recuperado' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        $ultimaPerforacion = Perforacion::where('reporte_id', $request->reporte_id)->orderBy('id', 'desc')->first();
        if ($ultimaPerforacion) {
            if ($ultimaPerforacion->hasta != $request->desde) {
                return response()->json(['errors' => ['desde' => ['El campo desde no puede ser menor al del ultimo registro']]], 201); // Código de estado 422 para errores de validación
            }
        }

        // Si no existe, creamos un nuevo registro
        $perforacion = Perforacion::create([
            'reporte_id' => $request->reporte_id,
            'desde' => $request->desde,
            'hasta' => $request->hasta,
            'perforado' => $request->perforado,
            'recuperado' => $request->recuperado,
            'porcentaje' => $request->porcentaje,
            'numero_cajas' => $request->numero_cajas,
            'status' => 1
        ]);

        return response()->json(['message' => 'Creado exitosamente', 'perforacion' => $perforacion], 201);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'desde' => 'required|not_in:0',
            'hasta' => 'required|not_in:0',
            'perforado' => 'required|not_in:0',
            'recuperado' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        $perforacion = Perforacion::findOrFail($id);
        $perforacion->update([
            'desde' => $request->desde,
            'hasta' => $request->hasta,
            'perforado' => $request->perforado,
            'recuperado' => $request->recuperado,
            'porcentaje' => $request->porcentaje,
            'numero_cajas' => $request->numero_cajas,
        ]);

        $updatedPerforacion = Perforacion::where('id', '=', $perforacion['id'])->first();
        return response()->json(['message' => 'Se actualizó correctamente', 'perforacion' => $updatedPerforacion], 201);
    }

    public function delete($id)
    {
        $perforacion = Perforacion::find($id);

        if (!$perforacion) {
            return response()->json([
                'message' => 'no encontrado'
            ], 404);
        }

        $deletedPerforacion = Perforacion::where('id', '=', $perforacion['id'])->first();

        // Elimina el personal
        $deletedPerforacion->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'Eliminado exitosamente',
            'deleted_perforacion' => $deletedPerforacion
        ], 200);
    }
}
