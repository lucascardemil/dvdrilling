<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\MatrizChecklistCategoria;
use App\Models\MatrizChecklistIntervencion;

class MatrizChecklistCategoriaController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:matriz');
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
        $categoriaMatrizChecklist = MatrizChecklistCategoria::create([
            'nombre' => $request->nombre,
            'status' => 1,
            'matriz_checklist_id' => $request->matriz_checklist_id,
        ]);

        return response()->json(['message' => 'La Categoria creado exitosamente', 'categoriaMatrizChecklist' => $categoriaMatrizChecklist], 201);
    }

    public function update(Request $request, $id)
    {

        $categoriaMatrizChecklist = MatrizChecklistCategoria::findOrFail($id);
        $categoriaMatrizChecklist->update([
            'nombre' => $request->nombre
        ]);

        return response()->json(['message' => 'La Categoria se actualizo exitosamente', 'categoriaMatrizChecklist' => $categoriaMatrizChecklist], 201);
    }

    public function delete($id)
    {
        $categoriaMatrizChecklist = MatrizChecklistCategoria::find($id);

        if (!$categoriaMatrizChecklist) {
            return response()->json([
                'message' => 'Categoria no encontrado'
            ], 404);
        }

        $intervenciones = MatrizChecklistIntervencion::where('matriz_checklist_categoria_id', $categoriaMatrizChecklist->id)->get();

        if (!$intervenciones->isEmpty()) {
            foreach ($intervenciones as $intervencion) {
                $intervencionMatrizChecklist = MatrizChecklistIntervencion::find($intervencion->id);
                $intervencionMatrizChecklist->delete();
            }
        }

        $categoriaMatrizChecklist->delete();

        return response()->json([
            'message' => 'La Categoria eliminado exitosamente',
            'categoriaMatrizChecklist' => $categoriaMatrizChecklist
        ], 200);
    }
}
