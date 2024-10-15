<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\IntervencionChecklist;

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

        if (empty($request->intervenciones)) {
            return response()->json(['errors' => 'No a seleccionado ninguna intervencion'], 201);
        }

        foreach ($request->intervenciones as $intervencion) {
            IntervencionChecklist::create([
                'checklist_id' => $request->checklist_id,
                'matriz_categorias_checklist_id' => $intervencion['categoria_id'],
                'matriz_intervencion_checklist_id' => $intervencion['intervencion_id'],
                'status' => false
            ]);
        }

        return response()->json(['message' => 'Las intervenciones creado exitosamente'], 201);
    }
}
