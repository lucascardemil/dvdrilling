<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Activo;
use App\Models\ActivoImagen;

class ActivosController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:activos');
    }

    public function index()
    {
        return view('activos.index');
    }

    public function all_select()
    {
        $actividades = Activo::where('status', '=', 1)->get();
        return response()->json($actividades);
    }

    public function all()
    {
        $tipo_activos = Activo::with('tipo_activo', 'imagenes')->get();
        return response()->json($tipo_activos);
    }


    public function store(Request $request)
    {
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'tipo_activo' => 'required|integer|exists:tipo_activos,id',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'patente' => 'required|string|max:255|unique:activos,patente',
            'numero_interno' => 'required|string|max:255|unique:activos,numero_interno',
            'year' => 'required|integer|min:0',
            'horometro' => 'nullable|integer|min:0',
            'kilometraje' => 'nullable|integer|min:0',
            'color' => 'required|string|max:50',
            'chasis' => 'required|string|max:255|unique:activos,chasis',
            'numero_motor' => 'required|string|max:255|unique:activos,numero_motor',
        ]);

        // Si la validación falla, retornar los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        // Crear el nuevo activo
        $activo = Activo::create([
            'tipo_activo_id' => $request->tipo_activo,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'patente' => $request->patente,
            'numero_interno' => $request->numero_interno,
            'year' => $request->year,
            'horometro' => $request->horometro,
            'kilometraje' => $request->kilometraje,
            'color' => $request->color,
            'chasis' => $request->chasis,
            'numero_motor' => $request->numero_motor,
            'status' => 0, // Estado inicial, puedes cambiarlo según sea necesario
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Activo creado exitosamente', 'activo' => $activo], 201);
    }


    public function update(Request $request, $id)
    {
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'tipo_activo' => 'required|integer|exists:tipo_activos,id',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'patente' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activos', 'patente')->ignore($id),
            ],
            'numero_interno' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activos', 'numero_interno')->ignore($id),
            ],
            'year' => 'required|integer|min:0',
            'horometro' => 'nullable|integer|min:0',
            'kilometraje' => 'nullable|integer|min:0',
            'color' => 'required|string|max:50',
            'chasis' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activos', 'chasis')->ignore($id),
            ],
            'numero_motor' => [
                'required',
                'string',
                'max:255',
                Rule::unique('activos', 'numero_motor')->ignore($id),
            ],
        ]);

        // Si la validación falla, retornar los errores
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        // Encontrar el activo por ID
        $activo = Activo::findOrFail($id);

        // Actualizar los datos del activo
        $activo->update([
            'tipo_activo_id' => $request->tipo_activo,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'patente' => $request->patente,
            'numero_interno' => $request->numero_interno,
            'year' => $request->year,
            'horometro' => $request->horometro,
            'kilometraje' => $request->kilometraje,
            'color' => $request->color,
            'chasis' => $request->chasis,
            'numero_motor' => $request->numero_motor,
        ]);

        // Retornar una respuesta de éxito
        return response()->json(['message' => 'Activo actualizado exitosamente', 'activo' => $activo], 201);
    }

    public function update_status(Request $request, $id)
    {
        $activo = Activo::findOrFail($id);
        $activo->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del Activo se actualizó correctamente', 'activo' => $activo], 201);
    }


    public function update_imagenes(Request $request)
    {
        // Validar los archivos subidos
        $request->validate([
            'imagenes.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $images = $request->file('imagenes');
        $savedImages = [];

        foreach ($images as $image) {
            // Guardar en 'storage/app/imagenes'
            $path = $image->store('public/imagenes', 'local');

            // Crear un registro en la base de datos
            $activoImagen = ActivoImagen::create([
                'ruta' => $path,
                'status' => 0,
                'activo_id' => $request->activo_id,
            ]);

            $savedImages[] = $activoImagen;
        }

        return response()->json([
            'message' => 'Imágenes actualizadas correctamente.',
            'imagenes' => $savedImages
        ], 201);
    }
}
