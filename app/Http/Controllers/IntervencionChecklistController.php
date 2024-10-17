<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\IntervencionChecklist;
use App\Models\Checklist;

class IntervencionChecklistController extends Controller
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
        $intervenciones = IntervencionChecklist::where('checklist_id', $id)->get();
        return response()->json($intervenciones);
    }

    public function store(Request $request)
    {
        $allFalse = true;

        if (empty($request->intervenciones)) {
            return response()->json(['errors' => 'No a seleccionado ninguna intervencion'], 201);
        }

        foreach ($request->intervenciones as $intervencion) {
            if ($intervencion['selected'] === true) {
                $allFalse = false;
                break; // Si encontramos un "selected" en true, dejamos de verificar
            }
        }

        // Si todos los elementos están en false, devolver un error
        if ($allFalse) {
            return response()->json(['error' => 'Todos los elementos están en false'], 400);
        }

        foreach ($request->intervenciones as $intervencion) {
            $intervenciones_selected = IntervencionChecklist::where('checklist_id', $request->checklist_id)
                ->where('matriz_categorias_checklist_id', $intervencion['categoria_id'])
                ->where('matriz_intervencion_checklist_id', $intervencion['intervencion_id'])
                ->first();

            if ($intervenciones_selected) {
                if ($intervencion['selected'] == false) {
                    $intervenciones_selected->delete();
                }
            }else{
                IntervencionChecklist::create([
                    'checklist_id' => $request->checklist_id,
                    'matriz_categorias_checklist_id' => $intervencion['categoria_id'],
                    'matriz_intervencion_checklist_id' => $intervencion['intervencion_id'],
                    'status' => false
                ]);
            }
        }

        $checklist = Checklist::findOrFail($request->checklist_id);
        $checklist->update([
            'status' => false
        ]);

        $checklist = Checklist::with('activo.tipo_activo', 'matriz.categorias.intervenciones.observaciones')->get();

        return response()->json(['message' => 'Las intervenciones creado exitosamente', 'checklist' => $checklist], 201);
    }
}
