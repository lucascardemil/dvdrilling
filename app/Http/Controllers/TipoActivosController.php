<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\TipoActivo;

class TipoActivosController extends Controller
{
    use AuthorizesRequests;
    
    public function all_select()
    {
        $tipo_activos = TipoActivo::where('status', '=', 1)->get();
        return response()->json($tipo_activos);
    }
    
    public function all()
    {
        $tipo_activos = TipoActivo::all();
        return response()->json($tipo_activos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:tipo_activos,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $tipo_activos = TipoActivo::create([
            'name' => $request->name,
            'status' => 0,
        ]);

        return response()->json(['message' => 'TipoActivo creado exitosamente', 'tipo_activos' => $tipo_activos], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('tipo_activos', 'name')->ignore($id),
        ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $tipo_activos = TipoActivo::findOrFail($id);
        $tipo_activos->update([
            'name' => $request->name
        ]);
        return response()->json(['message' => 'El tipo activo se actualizo', 'tipo_activos' => $tipo_activos], 201);
    }

    public function update_status(Request $request, $id)
    {
        $tipo_activos = TipoActivo::findOrFail($id);
        $tipo_activos->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del tipo activo se actualizó correctamente', 'tipo_activos' => $tipo_activos], 201);
    }
}
