<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\CoronaEscareador;

class CoronaEscareadorController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function all($id)
    {
        $coronaEscareador = CoronaEscareador::where('reporte_id', $id)->get();
        return response()->json($coronaEscareador);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'reporte_id' => 'required|exists:reportes,id',
            'detalle' => 'required|not_in:0',
            'desde' => 'required|not_in:0',
            'hasta' => 'required|not_in:0',
            'diametro' => 'required|not_in:0',
            'numero_corona' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Si no existe, creamos un nuevo registro
        $coronaEscareador = CoronaEscareador::create([
            'reporte_id' => $request->reporte_id,
            'detalle' => $request->detalle,
            'desde' => $request->desde,
            'hasta' => $request->hasta,
            'numero_corona' => $request->numero_corona,
            'diametro' => $request->diametro,
            'status' => 1
        ]);

        return response()->json(['message' => 'Creado exitosamente', 'corona_escareador' => $coronaEscareador], 201);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'detalle' => 'required|not_in:0',
            'desde' => 'required|not_in:0',
            'hasta' => 'required|not_in:0',
            'diametro' => 'required|not_in:0',
            'numero_corona' => 'required|not_in:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        $coronaEscareador = CoronaEscareador::findOrFail($id);
        $coronaEscareador->update([
            'detalle' => $request->detalle,
            'desde' => $request->desde,
            'hasta' => $request->hasta,
            'numero_corona' => $request->numero_corona,
            'diametro' => $request->diametro,
        ]);

        $updatedCoronaEscareador = CoronaEscareador::where('id', '=', $coronaEscareador['id'])->first();
        return response()->json(['message' => 'Se actualizó correctamente', 'corona_escareador' => $updatedCoronaEscareador], 201);
    }

    public function delete($id)
    {
        $coronaEscareador = CoronaEscareador::find($id);

        if (!$coronaEscareador) {
            return response()->json([
                'message' => 'no encontrado'
            ], 404);
        }

        $deletedCoronaEscareador = CoronaEscareador::where('id', '=', $coronaEscareador['id'])->first();

        // Elimina el personal
        $deletedCoronaEscareador->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'Eliminado exitosamente',
            'deleted_corona_escareador' => $deletedCoronaEscareador
        ], 200);
    }
}
