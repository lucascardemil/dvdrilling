<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Horometro;

class HorometroController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function all($id)
    {
        $horometro = Horometro::where('reporte_id', $id)->get();
        return response()->json($horometro);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'reporte_id' => 'required|exists:reportes,id',
            'inicio' => 'required|not_in:0',
            'termino' => 'required|not_in:0',
            'numero_cajas' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Buscar si ya existe un horómetro para el reporte_id dado
        $horometro = Horometro::where('reporte_id', $request->reporte_id)->first();

        if ($horometro) {
            if ($horometro->numero_cajas >= intval($request->numero_cajas)) {
                return response()->json(['errors' => ['numero_cajas' => true]], 201);
            } else {

                $horometro->update([
                    'termino' => $request->termino,
                    'numero_cajas' => $request->numero_cajas
                ]);

                return response()->json(['message' => 'Horometro actualizado exitosamente', 'horometro' => $horometro], 200);
            }
        }

        // Si no existe, creamos un nuevo registro
        $horometro = Horometro::create([
            'reporte_id' => $request->reporte_id,
            'inicio' => $request->inicio,
            'termino' => $request->termino,
            'numero_cajas' => $request->numero_cajas,
            'status' => 1
        ]);

        return response()->json(['message' => 'Horometro creado exitosamente', 'horometro' => $horometro], 201);
    }
}
