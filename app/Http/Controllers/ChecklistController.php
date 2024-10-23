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
        $relations = ['activo.tipo_activo', 'matriz', 'categorias.intervenciones.condiciones', 'categorias.intervenciones.observaciones.imagenes'];

        // Si el rol es 'usuario', filtrar por el user_id
        if ($rol === 'usuario') {
            $reportes = Checklist::with($relations)->where('user_id', $user->id)->get();
            return response()->json($reportes);
        }

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
            'activo_id' => 'required|exists:activos,id',
            'matriz_checklist_id' => 'required|exists:matriz_checklist,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201); // Código de estado 422 para errores de validación
        }


        $checklist_id = Checklist::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'horometro' => 0,
            'activo_id' => $request->activo_id,
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

        $checklist = Checklist::with('activo.tipo_activo', 'matriz', 'categorias.intervenciones')->where('id', $checklist_id)->first();
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
        $errores = [];
        $checklistCondicion = [];

        foreach ($request['checkslist'] as $checklist) {

            if ($checklist['existe'] == null || $checklist['estado'] == null) {
                $errores[] = ['categoria' => $checklist['categoria'], 'intervencion' => $checklist['intervencion'], 'existe' => $checklist['existe'], 'estado' => $checklist['estado']];
            } else {
                $checklistCondicion[] = ChecklistCondicion::updateOrCreate([
                    'checklist_intervencion_id' => $checklist['intervencion_id'],
                ], [
                    'existe' => $checklist['existe'],
                    'estado' => $checklist['estado'],
                    'status' => 1
                ]);
            }
        }

        if (!empty($errores)) {
            return response()->json(['errors' => $errores], 201);
        }

        if (!empty($checklistCondicion)) {
            $checklist = Checklist::findOrFail($request['checklist_id']);
            $checklist->update([
                'status' => 0
            ]);
        }

        return response()->json(['message' => 'La Checklist se completó correctamente', 'checklistCondicion' => $checklistCondicion], 201);
    }
}
