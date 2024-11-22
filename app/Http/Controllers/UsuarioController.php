<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        // // Verificar si el usuario pertenece a una brigada
        // $brigada = Brigada::where('usuario_id', $usuario->id)->first();

        // // Si pertenece a una brigada, devolvemos un flag en la respuesta
        // $isBrigada = $brigada ? true : false;

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'user' => $usuario,
            'rol' => $usuario->rol,
            // 'isBrigada' => $isBrigada  // Devuelve true si el usuario está en brigadas
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
                $nombre = "REG-".str_pad($i, 5, '0', STR_PAD_LEFT);;               
            } else {
                $nombre = "LAB-".str_pad($i, 5, '0', STR_PAD_LEFT);;  
            }
            $password = $this->generateRandomPassword(8);
            // Validaciones
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'password' => 'required|string',
                // 'estado' => 'required',
                'rol_id' => 'required|exists:rols,id', // Asegurarse de que el rol exista
            ]);

            // Crear el usuario
            $usuario = Usuario::create([
                'nombre' => $validatedData['nombre'],
                'password' => Hash::make($validatedData['password']), // Encriptar la contraseña
                // 'estado' => $validatedData['estado'],
                'rol_id' => $validatedData['rol_id'],
            ]);
        }
        // Devolver el ID del usuario en la respuesta
        return response()->json(['id' => $usuario->id], 201);
    }
    public function confirmarDatos(Request $request)
    {
        // Validaciones
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string',
            'telefono' => 'required',
            'ci' => 'required',
        ]);

        // Crear el usuario
        $usuario = Usuario::create([
            'nombres' => $validatedData['nombres'],
            'apellidos' => $validatedData['apellidos'],
            'telefono' => $validatedData['telefono'],
            'ci' => $validatedData['ci'],
        ]);
        // Devolver el ID del usuario en la respuesta
        return response()->json(201);
    }
}
