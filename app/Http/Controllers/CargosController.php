<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Cargo;

class CargosController extends Controller
{
    use AuthorizesRequests;

    
    
    public function all_select()
    {
        $cargos = Cargo::where('status', '=', 1)->get();
        return response()->json($cargos);
    }
    
    public function all()
    {
        $cargos = Cargo::all();
        return response()->json($cargos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cargos,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $cargo = Cargo::create([
            'name' => $request->name,
            'status' => 1,
        ]);

        return response()->json(['message' => 'Cargo creado exitosamente', 'cargo' => $cargo], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('cargos', 'name')->ignore($id),
        ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $cargo = Cargo::findOrFail($id);
        $cargo->update([
            'name' => $request->name
        ]);
        return response()->json(['message' => 'El cargo se actualizo', 'cargo' => $cargo], 201);
    }

    public function update_status(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del cargo se actualizó correctamente', 'cargo' => $cargo], 201);
    }
}
