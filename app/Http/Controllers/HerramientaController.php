<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Herramienta;

class HerramientaController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function all($id)
    {
        $herramienta = Herramienta::where('reporte_id', $id)->get();
        return response()->json($herramienta);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'reporte_id' => 'required|exists:reportes,id',
            'total_barril' => 'required|not_in:0',
            'muerto' => 'required|not_in:0',
            'contra' => 'required|not_in:0',
            'f_inicio' => 'required|not_in:0',
            'f_termino' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Buscar si ya existe un horómetro para el reporte_id dado
        $herramienta = Herramienta::where('reporte_id', $request->reporte_id)->first();

        if ($herramienta) {
            $herramienta->update([
                'barras_3' => $request->barras_3,
                'barras_3_5' => $request->barras_3_5,
                'barril' => $request->barril,
                'total_barril' => $request->total_barril,
                'muerto' => $request->muerto,
                'contra' => $request->contra,
                'f_inicio' => $request->f_inicio,
                'f_termino' => $request->f_termino,
                'recuperacion' => $request->recuperacion,
            ]);

            return response()->json(['message' => 'Herramienta actualizado exitosamente', 'herramienta' => $herramienta], 200);
        }

        // Si no existe, creamos un nuevo registro
        $herramienta = Herramienta::create([
            'reporte_id' => $request->reporte_id,
            'barras_3' => $request->barras_3,
            'barras_3_5' => $request->barras_3_5,
            'barril' => $request->barril,
            'total_barril' => $request->total_barril,
            'muerto' => $request->muerto,
            'contra' => $request->contra,
            'f_inicio' => $request->f_inicio,
            'f_termino' => $request->f_termino,
            'recuperacion' => $request->recuperacion,
            'status' => 1
        ]);

        return response()->json(['message' => 'Herramienta creado exitosamente', 'herramienta' => $herramienta], 201);
    }
}
