<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\AsignarPersonal;
use App\Models\AsignarActivo;
use App\Models\Personal;
use App\Models\Activo;

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

    public function all_asignar_activos()
    {
        $asignarActivo = AsignarActivo::with(['activo.tipo_activo', 'proyecto'])->get();
        return response()->json($asignarActivo);
    }

    public function store_activo(Request $request)
    {
        $asignarIds = array();

        // Validar que activo_id sea un arreglo
        $validator = Validator::make($request->all(), [
            'activo_id' => 'required|array',
            'activo_id.*' => 'required|integer',
            'proyecto_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        // Iterar sobre cada activo_id
        foreach ($request->activo_id as $activoId) {
            $asignarActivo = AsignarActivo::create([
                'activo_id' => $activoId,
                'proyecto_id' => $request->proyecto_id,
                'status' => 0,
            ]);

            $asignarIds[] = $asignarActivo->id;
        }

        $recursoActivo = AsignarActivo::with(['activo.tipo_activo', 'proyecto'])->whereIn('id', $asignarIds)->get();

        return response()->json(['message' => 'Activo fue asignado exitosamente', 'recursoActivo' => $recursoActivo], 201);
    }

    public function delete_activo($id)
    {
        $activo = AsignarActivo::find($id);

        if (!$activo) {
            return response()->json([
                'message' => 'Activo no encontrado'
            ], 404);
        }

        $deletedActivo = Activo::with('tipo_activo')->where('id', '=', $activo['activo_id'])->first();

        // Elimina el personal
        $activo->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'Activo eliminado exitosamente',
            'deleted_activo' => $deletedActivo
        ], 200);
    }

    public function update_activo(Request $request, $id)
    {
        $activo = AsignarActivo::findOrFail($id);
        $activo->update([
            'proyecto_id' => $request->proyecto
        ]);
        $updatedActivo = AsignarActivo::with(['activo.tipo_activo', 'proyecto'])->where('id', $activo->id)->first();
        return response()->json(['message' => 'El proyecto se actualizó correctamente', 'updated_activo' => $updatedActivo], 201);
    }

    public function all_asignar_personal()
    {
        $asignarPersonal = AsignarPersonal::with(['personal.cargo', 'proyecto'])->get();
        return response()->json($asignarPersonal);
    }

    public function store_personal(Request $request)
    {
        $asignarIds = array();

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

            $asignarIds[] = $asignarPersonal->id;
        }

        $recursoPersonal = AsignarPersonal::with(['personal.cargo', 'proyecto'])->whereIn('id', $asignarIds)->get();

        return response()->json(['message' => 'Personal fue asignado exitosamente', 'recursoPersonal' => $recursoPersonal], 201);
    }

    public function delete_personal($id)
    {
        $personal = AsignarPersonal::find($id);

        if (!$personal) {
            return response()->json([
                'message' => 'Personal no encontrado'
            ], 404);
        }

        $deletedPersonal = Personal::with('cargo')->where('id', '=', $personal['personal_id'])->first();

        // Elimina el personal
        $personal->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'Personal eliminado exitosamente',
            'deleted_personal' => $deletedPersonal
        ], 200);
    }

    public function update_personal(Request $request, $id)
    {
        $personal = AsignarPersonal::findOrFail($id);
        $personal->update([
            'proyecto_id' => $request->proyecto
        ]);
        $updatedPersonal = AsignarPersonal::with(['personal.cargo', 'proyecto'])->where('id', $personal->id)->first();
        return response()->json(['message' => 'El proyecto se actualizó correctamente', 'updated_personal' => $updatedPersonal], 201);
    }
}
