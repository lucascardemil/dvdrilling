<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\ChecklistCategoria;
use App\Models\ChecklistIntervencion;

class ChecklistCategoriaController extends Controller
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
        $categoriaChecklist = ChecklistCategoria::create([
            'nombre' => $request->nombre,
            'status' => 1,
            'checklist_id' => $request->checklist_id,
        ]);

        return response()->json(['message' => 'La Categoria creado exitosamente', 'categoriaChecklist' => $categoriaChecklist], 201);
    }

    public function update(Request $request, $id)
    {

        $categoriaChecklist = ChecklistCategoria::findOrFail($id);
        $categoriaChecklist->update([
            'nombre' => $request->nombre
        ]);

        return response()->json(['message' => 'La Categoria se actualizo exitosamente', 'categoriaChecklist' => $categoriaChecklist], 201);
    }

    public function delete($id)
    {
        $categoriaChecklist = ChecklistCategoria::find($id);

        if (!$categoriaChecklist) {
            return response()->json([
                'message' => 'Intervencion no encontrado'
            ], 404);
        }

        $intervenciones = ChecklistIntervencion::where('checklist_categoria_id', $categoriaChecklist->id)->get();

        if (!$intervenciones->isEmpty()) {
            foreach ($intervenciones as $intervencion) {
                $intervencionChecklist = ChecklistIntervencion::find($intervencion->id);
                $intervencionChecklist->delete();
            }
        }

        $categoriaChecklist->delete();

        return response()->json([
            'message' => 'La Categoria eliminado exitosamente',
            'categoriaChecklist' => $categoriaChecklist
        ], 200);
    }
}
