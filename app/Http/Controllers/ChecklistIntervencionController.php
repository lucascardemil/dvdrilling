<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\ChecklistIntervencion;
use App\Models\Checklist;

class ChecklistIntervencionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:checklist');
    }

    public function index()
    {
        return view('checklist.index');
    }

    public function all($id)
    {
        $intervenciones = Checklist::with('categorias.intervenciones')->where('id', $id)->get();
        return response()->json($intervenciones);
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
        $intervencionChecklist = ChecklistIntervencion::create([
            'nombre' => $request->nombre,
            'status' => 1,
            'checklist_categoria_id' => $request->checklist_categoria_id
        ]);

        $intervencion = ChecklistIntervencion::with('categoria')->where('id', $intervencionChecklist->id)->first();

        return response()->json(['message' => 'La Intervencion creado exitosamente', 'intervencionChecklist' => $intervencion], 201);
    }

    public function update(Request $request, $id)
    {

        $intervencionChecklist = ChecklistIntervencion::findOrFail($id);
        $intervencionChecklist->update([
            'nombre' => $request->nombre
        ]);

        return response()->json(['message' => 'La Intervencion se actualizo exitosamente', 'intervencionChecklist' => $intervencionChecklist], 201);
    }

    public function delete($id)
    {
        $intervencionChecklist = ChecklistIntervencion::find($id);

        if (!$intervencionChecklist) {
            return response()->json([
                'message' => 'Intervencion no encontrado'
            ], 404);
        }

        // Elimina el personal
        $intervencionChecklist->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'La Intervencion eliminado exitosamente',
            'intervencionChecklist' => $intervencionChecklist
        ], 200);
    }
}
