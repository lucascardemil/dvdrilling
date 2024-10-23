<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use App\Models\ChecklistObservacion;
use App\Models\ChecklistObservacionImagen;

class ChecklistObservacionController extends Controller
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

    public function store(Request $request)
    {
        // Validar una imagen
        $request->validate([
            'observacion' => 'required|string|max:255',
        ]);

        // Obtener la imagen y almacenarla
        $imagen = $request->file('imagen');

        // Crear la observación
        $observacion_id = ChecklistObservacion::create([
            'observacion' => $request->observacion,
            'checklist_intervencion_id' => $request->checklist_intervencion_id,
        ])->id;

        if ($observacion_id && $imagen) {
            $path = $imagen->store('public/observaciones', 'local');
            ChecklistObservacionImagen::create([
                'imagen' => $path,
                'checklist_observacion_id' => $observacion_id,
            ]);
        }


        $observacionChecklist = ChecklistObservacion::with('imagenes')->where('id', $observacion_id)->first();

        // Retornar la respuesta JSON
        return response()->json([
            'message' => 'La observación ha sido creada exitosamente',
            'observacionChecklist' => $observacionChecklist
        ], 201);
    }

    public function delete($id)
    {
        $observacionChecklist = ChecklistObservacion::find($id);

        if (!$observacionChecklist) {
            return response()->json([
                'message' => 'Observación no encontrado'
            ], 404);
        }

        $observacionImagen = ChecklistObservacionImagen::where('checklist_observacion_id', $observacionChecklist->id)->first();

        if ($observacionImagen) {
            $rutaImagen = $observacionImagen->imagen;

            if (Storage::disk('public')->exists(str_replace('public/', '', $rutaImagen))) {
                Storage::disk('public')->delete(str_replace('public/', '', $rutaImagen));
            }

            $observacionImagen->delete();
        }


        $observacionChecklist->delete();
        return response()->json([
            'message' => 'La observación fue eliminado exitosamente',
            'observacionChecklist' => $observacionChecklist
        ], 200);
    }
}
