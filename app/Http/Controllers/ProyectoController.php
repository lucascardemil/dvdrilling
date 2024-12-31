<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:proyecto')->only('index');
    }

    public function index()
    {
        return view('proyecto.index');
    }

    public function all_select()
    {
        $proyectos = Proyecto::where('status', '=', 1)->get();
        return response()->json($proyectos);
    }

    public function all()
    {
        $proyectos = Proyecto::all();
        return response()->json($proyectos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:proyectos,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $proyecto = Proyecto::create([
            'name' => $request->name,
            'status' => 0,
        ]);

        return response()->json(['message' => 'Proyecto creado exitosamente', 'proyecto' => $proyecto], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('proyectos', 'name')->ignore($id),
        ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update([
            'name' => $request->name
        ]);
        return response()->json(['message' => 'El proyecto se actualizo', 'proyecto' => $proyecto], 201);
    }

    public function update_status(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del proyecto se actualizó correctamente', 'proyecto' => $proyecto], 201);
    }
}
