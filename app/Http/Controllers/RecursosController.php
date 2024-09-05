<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\AsignarPersonal;

class RecursosController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:recursos');
    }

    public function index()
    {
        return view('recursos.index');
    }

    public function all_asignar_personal()
    {
        $asignarPersonal = AsignarPersonal::with(['personal.cargo', 'proyecto'])->get();
        return response()->json($asignarPersonal);
    }

    public function store_personal(Request $request)
    {
        $recursoPersonal = array();

        // Validar que personal_id sea un arreglo
        $validator = Validator::make($request->all(), [
            'personal_id' => 'required|array',
            'personal_id.*' => 'required|integer',
            'proyecto_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        // Iterar sobre cada personal_id
        foreach ($request->personal_id as $personalId) {
            $asignarPersonal = AsignarPersonal::create([
                'personal_id' => $personalId,
                'proyecto_id' => $request->proyecto_id,
                'status' => 0,
            ]);

            $recursoPersonal[] = $asignarPersonal;
        }

        return response()->json(['message' => 'Personal fue asignado exitosamente', 'recursoPersonal' => $recursoPersonal], 201);
    }
}
