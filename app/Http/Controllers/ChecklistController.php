<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Checklist;

class ChecklistController extends Controller
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

    public function all()
    {
        $checklist = Checklist::with('activo.tipo_activo', 'matriz.categorias.intervenciones.observaciones')->get();
        return response()->json($checklist);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'activo_id' => 'required|exists:activos,id',
            'matriz_checklist_id' => 'required|exists:matriz_checklist,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Si no existe, creamos un nuevo registro
        $checklistCreada = Checklist::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'activo_id' => $request->activo_id,
            'matriz_checklist_id' => $request->matriz_checklist_id,
            'status' => false
        ]);

        $checklist = Checklist::with('activo.tipo_activo', 'matriz.categorias.intervenciones.observaciones')->where('id', $checklistCreada->id)->first();

        return response()->json(['message' => 'La Checklist creado exitosamente', 'checklist' => $checklist], 201);
    }

    public function update(Request $request, $id)
    {

        $checklist = Checklist::findOrFail($id);
        $checklist->update([
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Se gereno correctamente la matriz de checklist', 'checklist' => $checklist], 201);
    }

    public function update_status(Request $request, $id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklist->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del Checklist se actualizó correctamente', 'checklist' => $checklist], 201);
    }
}
