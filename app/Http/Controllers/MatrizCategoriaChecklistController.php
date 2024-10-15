<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\MatrizCategoriaChecklist;

class MatrizCategoriaChecklistController extends Controller
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
        $categoriaMatrizChecklist = MatrizCategoriaChecklist::create([
            'nombre' => $request->nombre,
            'status' => false,
            'matriz_checklist_id' =>$request->matrizChecklist_id,
        ]);

        return response()->json(['message' => 'La Categoria creado exitosamente', 'categoriaMatrizChecklist' => $categoriaMatrizChecklist], 201);
    }

    public function update(Request $request, $id)
    {

        $categoriaMatrizChecklist = MatrizCategoriaChecklist::findOrFail($id);
        $categoriaMatrizChecklist->update([
            'nombre' => $request->nombre
        ]);

        return response()->json(['message' => 'La Categoria se actualizo exitosamente', 'categoriaMatrizChecklist' => $categoriaMatrizChecklist], 201);
    }

    public function delete($id)
    {
        $categoriaMatrizChecklist = MatrizCategoriaChecklist::find($id);

        if (!$categoriaMatrizChecklist) {
            return response()->json([
                'message' => 'Categoria no encontrado'
            ], 404);
        }

        // Elimina el personal
        $categoriaMatrizChecklist->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'La Categoria eliminado exitosamente',
            'categoriaMatrizChecklist' => $categoriaMatrizChecklist
        ], 200);
    }
}
