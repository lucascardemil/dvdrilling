<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Observacion;

class ObservacionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function all($id)
    {
        $observacion = Observacion::where('reporte_id', $id)->get();
        return response()->json($observacion);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'reporte_id' => 'required|exists:reportes,id',
            'observacion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Buscar si ya existe un horómetro para el reporte_id dado
        $observacion = Observacion::where('reporte_id', $request->reporte_id)->first();

        if ($observacion) {
            $observacion->update([
                'observacion' => $request->observacion,
            ]);

            return response()->json(['message' => 'Observacion actualizado exitosamente', 'observacion' => $observacion], 200);
        }

        // Si no existe, creamos un nuevo registro
        $observacion = Observacion::create([
            'reporte_id' => $request->reporte_id,
            'observacion' => $request->observacion,
        ]);

        return response()->json(['message' => 'Observacion creado exitosamente', 'observacion' => $observacion], 201);
    }
}
