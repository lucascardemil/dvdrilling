<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Actividad;

class ActividadesController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:actividades');
    }

    public function index()
    {
        return view('actividades.index');
    }

    public function all_select()
    {
        $actividades = Actividad::where('status', '=', 1)->get();
        return response()->json($actividades);
    }
    
    public function all()
    {
        $actividades = Actividad::all();
        return response()->json($actividades);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:actividades,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $actividad = Actividad::create([
            'name' => $request->name,
            'status' => 0,
        ]);

        return response()->json(['message' => 'Actividad creado exitosamente', 'actividad' => $actividad], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('actividades', 'name')->ignore($id),
        ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $actividad = Actividad::findOrFail($id);
        $actividad->update([
            'name' => $request->name
        ]);
        return response()->json(['message' => 'El actividad se actualizo', 'actividad' => $actividad], 201);
    }

    public function update_status(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        $actividad->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del actividad se actualizó correctamente', 'actividad' => $actividad], 201);
    }
}
