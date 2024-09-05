<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:usuarios');
    }

    public function index()
    {
        return view('usuarios.index');
    }

    public function all()
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'Usuario creado exitosamente', 'user' => $user], 201);
    }

    public function update(Request $request, $id)
    {
        if($request->rol_id === null){
            return response()->json(['errors' => 'No selecciono ningun rol'], 201);
        }

        $user = User::findOrFail($id);
        $role = Role::findOrFail($request->rol_id);
        $user->syncRoles([$role]);
        return response()->json(['message' => 'El Rol del Usuario se actualizo', 'user' => $user], 201);
    }

    public function update_status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del usuario se actualizó correctamente', 'user' => $user], 201);
    }
}
