<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Personal;

class PersonalController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:personal');
    }

    public function index()
    {
        return view('personal.index');
    }

    public function buscar_nombre($name = null)
    {
        $query = Personal::with('cargo')
            ->whereDoesntHave('asignaciones')
            ->where('status', '=', 1);

        if ($name) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        $personals = $query->get();

        return response()->json($personals);
    }


    public function all()
    {
        $personals = Personal::with('cargo')->get();
        return response()->json($personals);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:personals,name',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'run' => 'required|string|max:12|min:11|unique:personals,run',
            'cargo_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $personal = Personal::create([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'run' => $request->run,
            'cargo_id' => $request->cargo_id,
            'status' => 1,
        ]);

        return response()->json(['message' => 'Personal creado exitosamente', 'personal' => $personal], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('personals', 'name')->ignore($id)],
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'run' => ['required', 'string', 'max:12', 'min:11', Rule::unique('personals', 'run')->ignore($id)],
            'cargo_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $personal = Personal::findOrFail($id);
        $personal->update([
            'name' => $request->name,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'run' => $request->run,
            'cargo_id' => $request->cargo_id,

        ]);
        return response()->json(['message' => 'El personal se actualizo', 'personal' => $personal], 201);
    }


    public function update_status(Request $request, $id)
    {
        $personal = Personal::findOrFail($id);
        $personal->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del personal se actualizó correctamente', 'personal' => $personal], 201);
    }
}
