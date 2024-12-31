<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\MatrizChecklist;
use App\Models\Checklist;
use App\Models\ChecklistCategoria;
use App\Models\ChecklistIntervencion;
use App\Models\ChecklistCondicion;
use App\Models\ChecklistVehiculo;
use App\Models\ChecklistVehiculoDetalle;
use App\Models\ChecklistObservacion;
use Illuminate\Support\Facades\Auth;


class ChecklistController extends Controller
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

    public function all()
    {
        // Verificar si el usuario está autenticado
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Obtener el rol del usuario autenticado
        $rol = $user->getRoleNames()->first(); // Asumiendo que usas spatie/laravel-permission

        // Definir las relaciones a cargar con 'with'
        $relations = ['tipoactivo', 'matriz', 'categorias.intervenciones.condiciones.imagenes', 'vehiculos.detalles'];

        // Para otros roles, devolver todos los reportes
        $reportes = Checklist::with($relations)->get();
        return response()->json($reportes);
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'tipo_activo_id' => 'required|exists:tipo_activos,id',
            'matriz_checklist_id' => 'required|exists:matriz_checklist,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }


        $checklist_id = Checklist::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'horometro' => 0,
            'tipo_activo_id' => $request->tipo_activo_id,
            'user_id' => $user->id,
            'matriz_checklist_id' => $request->matriz_checklist_id,
            'status' => 1
        ])->id;

        $matrizChecklist = MatrizChecklist::with(['categorias' => function ($query) {
            $query->where('status', '!=', 0);
        }, 'categorias.intervenciones'])->where('id', $request->matriz_checklist_id)->get();


        if ($matrizChecklist) {
            foreach ($matrizChecklist as $checklist) {
                foreach ($checklist->categorias as $categoria) {
                    $categoria_id = ChecklistCategoria::create([
                        'nombre' => $categoria->nombre,
                        'status' => 1,
                        'checklist_id' => $checklist_id,
                    ])->id;

                    foreach ($categoria->intervenciones as $intervencion) {
                        ChecklistIntervencion::create([
                            'nombre' => $intervencion->nombre,
                            'status' => 1,
                            'checklist_categoria_id' => $categoria_id,
                        ]);
                    }
                }
            }
        }

        $checklist = Checklist::with('tipoactivo', 'matriz', 'categorias.intervenciones')->where('id', $checklist_id)->first();
        return response()->json(['message' => 'La Checklist creado exitosamente', 'checklist' => $checklist], 201);
    }

    public function update(Request $request, $id)
    {

        $checklist = Checklist::findOrFail($id);
        $checklist->update([
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Se gereno correctamente la matriz de checklist', 'checklist' => $checklist], 201);
    }

    public function update_status(Request $request, $id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklist->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del Checklist se actualizó correctamente', 'checklist' => $checklist], 201);
    }

    public function store_completar_checklist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patente' => 'required|string|max:255',
            'conductor' => 'required|string|max:255',
            'numero_interno' => 'required|string|max:255',
            'proyecto' => 'required|string|max:255',
            'faena' => 'required|string|max:255',
            'turno' => 'required|string|max:255',
            'observacion_bitacora' => 'required|string|max:255',
            'carga_combustible' => 'required|integer',
            'estado_equipo' => 'required|integer',
            'checklist_id' => 'required|integer',
            'kilometraje_inicial' => 'nullable|integer',
            'kilometraje_final' => 'nullable|integer',
            'horometro_inicial' => 'nullable|integer',
            'horometro_final' => 'nullable|integer',
        ]);

        $checkslist = json_decode($request['checkslist'], true);
        $errores = $this->validarCheckslist($checkslist);

        if (!empty($errores) || $validator->fails()) {
            return response()->json(['errors_checks' => $errores, 'errors' => $validator->errors()], 201);
        }

        $checklistVehiculo = $this->obtenerOcrearChecklistVehiculo($request);
        $checklistVehiculoDetalle = $this->crearDetalleChecklist($checklistVehiculo->id, $request);

        $this->guardarImagenVehiculo($checklistVehiculoDetalle, $request->file('imagen_combustible'));

        $checklistCondicion = $this->crearChecklistCondiciones($checkslist, $checklistVehiculo->id, $checklistVehiculoDetalle->id);

        if ($request['observaciones']) {
            $this->crearChecklistObservaciones($checklistCondicion, $request['observaciones']);
        }

        return response()->json([
            'message' => 'La Checklist se completó correctamente.',
            'checklistCondicion' => $checklistCondicion,
        ], 201);
    }

    // Función para validar checkslist
    private function validarCheckslist(array $checkslist)
    {
        $errores = [];
        foreach ($checkslist as $checklist) {
            if (is_null($checklist['existe']) || ($checklist['existe'] === 1 && is_null($checklist['estado']))) {
                $errores[] = [
                    'categoria' => $checklist['categoria'],
                    'intervencion' => $checklist['intervencion'],
                    'existe' => $checklist['existe'],
                    'estado' => $checklist['estado'],
                ];
            }
        }
        return $errores;
    }

    // Función para obtener o crear un ChecklistVehiculo
    private function obtenerOcrearChecklistVehiculo(Request $request)
    {
        return ChecklistVehiculo::firstOrCreate(
            ['patente' => $request['patente']],
            ['checklist_id' => $request['checklist_id'], 'status' => 1]
        );
    }

    // Función para crear el detalle del checklist
    private function crearDetalleChecklist($checklistVehiculoId, Request $request)
    {
        return ChecklistVehiculoDetalle::create([
            'checklist_vehiculo_id' => $checklistVehiculoId,
            'status' => 1,
            'patente' => $request['patente'],
            'conductor' => $request['conductor'],
            'kilometraje_inicial' => $request['kilometraje_inicial'],
            'kilometraje_final' => $request['kilometraje_final'],
            'horometro_inicial' => $request['horometro_inicial'],
            'horometro_final' => $request['horometro_final'],
            'numero_interno' => $request['numero_interno'],
            'proyecto' => $request['proyecto'],
            'faena' => $request['faena'],
            'turno' => $request['turno'],
            'litros' => $request['litros'],
            'observacion_bitacora' => $request['observacion_bitacora'],
            'carga_combustible' => $request['carga_combustible'],
            'estado_equipo' => $request['estado_equipo'],
        ]);
    }

    // Función para guardar la imagen vehiculos
    private function guardarImagenVehiculo($checklistVehiculoDetalle, $imagen)
    {
        if ($imagen) {
            $path = $imagen->store('public/checklist');
            $checklistVehiculoDetalle->update(['imagen_combustible' => $path]);
        }
    }

    // Función para crear condiciones del checklist
    private function crearChecklistCondiciones(array $checkslist, $checklistVehiculoId, $checklistVehiculoDetalleId)
    {
        $condiciones = [];
        foreach ($checkslist as $checklist) {
            $condiciones[] = ChecklistCondicion::create([
                'checklist_vehiculo_id' => $checklistVehiculoId,
                'checklist_vehiculo_detalle_id' => $checklistVehiculoDetalleId,
                'checklist_intervencion_id' => $checklist['intervencion_id'],
                'existe' => $checklist['existe'],
                'estado' => $checklist['estado'],
                'status' => 1,
            ]);
        }
        return $condiciones;
    }

    // Función para crear observaciones del checklist
    private function crearChecklistObservaciones(array $condiciones, $observaciones)
    {
        foreach ($condiciones as $condicion) {

            foreach ($observaciones as $observacion) {
                $imagenPath = null;
                $observacionTexto = $observacion['observacion'];

                if ($observacion['checklist_intervencion_id'] == $condicion['checklist_intervencion_id']) {
                    if (isset($observacion['imagen_observacion']) && $observacion['imagen_observacion'] instanceof \Illuminate\Http\UploadedFile) {
                        $path = $observacion['imagen_observacion']->store('public/observaciones');
                        $imagenPath = $path;
                    }

                    ChecklistObservacion::create([
                        'observacion' => $observacionTexto,
                        'checklist_condicion_id' => $condicion['id'],
                        'imagen' => $imagenPath
                    ]);
                }
            }
        }
    }
}
