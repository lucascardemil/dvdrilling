<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\MatrizChecklistIntervencion;

class MatrizChecklistIntervencionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:checklist');
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Si no existe, creamos un nuevo registro
        $intervencionMatrizChecklist = MatrizChecklistIntervencion::create([
            'nombre' => $request->nombre,
            'status' => 1,
            'matriz_checklist_categoria_id' => $request->matriz_checklist_categoria_id
        ]);

        $intervencion = MatrizChecklistIntervencion::with('categoria')->where('id', $intervencionMatrizChecklist->id)->first();

        return response()->json(['message' => 'La Intervencion creado exitosamente', 'intervencionMatrizChecklist' => $intervencion], 201);
    }

    public function update(Request $request, $id)
    {

        $intervencionMatrizChecklist = MatrizChecklistIntervencion::findOrFail($id);
        $intervencionMatrizChecklist->update([
            'nombre' => $request->nombre
        ]);

        return response()->json(['message' => 'La Intervencion se actualizo exitosamente', 'intervencionMatrizChecklist' => $intervencionMatrizChecklist], 201);
    }

    public function delete($id)
    {
        $intervencionMatrizChecklist = MatrizChecklistIntervencion::find($id);

        if (!$intervencionMatrizChecklist) {
            return response()->json([
                'message' => 'Intervencion no encontrado'
            ], 404);
        }

        // Elimina el personal
        $intervencionMatrizChecklist->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'La Intervencion eliminado exitosamente',
            'intervencionMatrizChecklist' => $intervencionMatrizChecklist
        ], 200);
    }
}
