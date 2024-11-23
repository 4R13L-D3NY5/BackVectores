<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //
    public function login(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar el usuario por nombre
        $usuario = Usuario::where('nombre', $request->nombre)->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // Iniciar sesión
        Auth::login($usuario);

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'user' => $usuario,
            // 'rol' => $usuario->rol,
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
    public function index()
    {
        return Usuario::all();
    }
    public function store(Request $request)
    {
        $numUsuariosExistentes = Usuario::where('rol_id', $request->rol)
            ->count();

        for ($i = $numUsuariosExistentes + 1; $i <= $numUsuariosExistentes + $request->numUsuarios; $i++) {
            if ($request->rol == 2) {
                $nombre = "REG-" . str_pad($i, 5, '0', STR_PAD_LEFT);;
            } else {
                $nombre = "LAB-" . str_pad($i, 5, '0', STR_PAD_LEFT);;
            }
            $password = Str::random(8);


            // Crear el usuario
            Usuario::create([
                'nombre' => $nombre,
                'password' => Hash::make($password), // Encriptar la contraseña
                // 'estado' => $validatedData['estado'],
                'rol_id' => $request->rol,
            ]);
        }
        // Devolver el ID del usuario en la respuesta
        return response()->json(['message' => 'Usuarios registrados correctamente'], 201);
    }
    public function update(Request $request)
    {
        // Validaciones
        $validatedData = $request->validate([
            'id' => 'required|exists:usuarios,id',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string',
            'telefono' => 'required',
            'ci' => 'required',
        ]);

        // Buscar y actualizar el usuario
        $usuario = Usuario::find($validatedData['id']);

        $usuario->update([
            'nombres' => $validatedData['nombres'],
            'apellidos' => $validatedData['apellidos'],
            'telefono' => $validatedData['telefono'],
            'ci' => $validatedData['ci'],
        ]);

        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }
}
