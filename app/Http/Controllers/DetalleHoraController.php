<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\DetalleHora;

class DetalleHoraController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:reportes');
    }

    public function all($id)
    {
        $detalleHora = DetalleHora::where('reporte_id', $id)->get();
        return response()->json($detalleHora);
    }

    public function store(Request $request)
    {
        // Validación de los datos antes de realizar cualquier operación
        $validator = Validator::make($request->all(), [
            'reporte_id' => 'required|exists:reportes,id',
            'de' => 'required',
            'a' => 'required|after:de',
            'actividad_id' => 'required|not_in:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        // Si no existe, creamos un nuevo registro
        $detalleHora = DetalleHora::create([
            'reporte_id' => $request->reporte_id,
            'de' => $request->de,
            'a' => $request->a,
            'actividad_id' => $request->actividad_id,
            'status' => 1
        ]);

        $actividad = Actividad::where('id', $detalleHora->actividad_id)->first();
        $detalleHora->actividad = [
            'name' => $actividad->name
        ];

        return response()->json(['message' => 'Creado exitosamente', 'detalleHora' => $detalleHora], 201);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'de' => 'required',
            'a' => 'required|after:de',
            'actividad_id' => 'required|not_in:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }

        $detalleHoras = DetalleHora::where('reporte_id', '=', $request->reporte_id)->where('id', '!=', $id)->get();
        foreach ($detalleHoras as $detalleHora) {
            if ($detalleHora->a == $request->a) {
                return response()->json(['errors' => ['a' => ['La hora ya fue registrada']]], 201); // Código de estado 422 para errores de validación
            }

            if ($detalleHora->de == $request->de) {
                return response()->json(['errors' => ['de' => ['La hora ya fue registrada']]], 201); // Código de estado 422 para errores de validación
            }

            if ($request->de < $detalleHora->a) {
                return response()->json(['errors' => ['de' => ['La hora De no puede ser menor a A']]], 201); // Código de estado 422 para errores de validación
            }

            if ($request->a > $detalleHora->de) {
                return response()->json(['errors' => ['a' => ['La hora A no puede ser mayor a De']]], 201); // Código de estado 422 para errores de validación
            }
        }

        $detalleHora = DetalleHora::findOrFail($id);
        $detalleHora->update([
            'de' => $request->de,
            'a' => $request->a,
            'actividad_id' => $request->actividad_id
        ]);

        $updatedDetalleHora = DetalleHora::where('id', '=', $detalleHora['id'])->first();
        return response()->json(['message' => 'Se actualizó correctamente', 'detalleHora' => $updatedDetalleHora], 201);
    }

    public function delete($id)
    {
        $detalleHora = DetalleHora::find($id);

        if (!$detalleHora) {
            return response()->json([
                'message' => 'no encontrado'
            ], 404);
        }

        $deletedDetalleHora = DetalleHora::where('id', '=', $detalleHora['id'])->first();

        // Elimina el personal
        $deletedDetalleHora->delete();

        // Retorna el personal eliminado junto con el mensaje de éxito
        return response()->json([
            'message' => 'Eliminado exitosamente',
            'deleted_perforacion' => $deletedDetalleHora
        ], 200);
    }
}
