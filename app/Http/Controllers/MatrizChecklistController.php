<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\MatrizChecklist;

class MatrizChecklistController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:checklist');
    }

    public function all()
    {
        $matrizChecklist = MatrizChecklist::with(['categorias' => function ($query) {
            $query->where('status', '!=', 0);
        }, 'categorias.intervenciones'])->get();

        return response()->json($matrizChecklist);
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
        $matrizChecklist = MatrizChecklist::create([
            'nombre' => $request->nombre,
            'status' => 1
        ]);

        return response()->json(['message' => 'La Matriz Checklist creado exitosamente', 'matrizChecklist' => $matrizChecklist], 201);
    }

    public function update(Request $request, $id)
    {

        $matrizChecklist = MatrizChecklist::findOrFail($id);
        $matrizChecklist->update([
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Se gereno correctamente la matriz de checklist', 'matrizChecklist' => $matrizChecklist], 201);
    }

    public function update_status(Request $request, $id)
    {
        $matrizChecklist = MatrizChecklist::findOrFail($id);
        $matrizChecklist->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del Matriz Checklist se actualizó correctamente', 'matrizChecklist' => $matrizChecklist], 201);
    }
}
