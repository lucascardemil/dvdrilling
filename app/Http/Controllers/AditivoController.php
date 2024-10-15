<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Aditivo;

class AditivoController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function all($id)
    {
        $aditivo = Aditivo::where('reporte_id', $id)->get();
        return response()->json($aditivo);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'reporte_id' => 'required|exists:reportes,id',
            'cantidad' => 'required|not_in:0',
            'detalle' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Si no existe, creamos un nuevo registro
        $aditivo = Aditivo::create([
            'reporte_id' => $request->reporte_id,
            'cantidad' => $request->cantidad,
            'detalle' => $request->detalle,
            'status' => 1
        ]);

        return response()->json(['message' => 'Creado exitosamente', 'aditivo' => $aditivo], 201);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|not_in:0',
            'detalle' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        $aditivo = Aditivo::findOrFail($id);
        $aditivo->update([
            'detalle' => $request->detalle,
            'cantidad' => $request->cantidad
        ]);

        $updatedAditivo = Aditivo::where('id', '=', $aditivo['id'])->first();
        return response()->json(['message' => 'Se actualizó correctamente', 'aditivo' => $updatedAditivo], 201);
    }

    public function delete($id)
    {
        $aditivo = Aditivo::find($id);

        if (!$aditivo) {
            return response()->json([
                'message' => 'no encontrado'
            ], 404);
        }

        $deletedAditivo = Aditivo::where('id', '=', $aditivo['id'])->first();

        // Elimina el personal
        $deletedAditivo->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'Eliminado exitosamente',
            'deleted_aditivo' => $deletedAditivo
        ], 200);
    }
}
