<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    //
    public function index()
    {
        $registros = Registro::all();
        return response()->json($registros, 200);
    }

    public function store(Request $request)
    {
        // Validaciones
        $validatedData = $request->validate([
            'fecha' => 'required|date',
            'longitud' => 'required|numeric',
            'latitud' => 'required|numeric',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcionRegistro' => 'nullable|string',
            'especie_id' => 'required|exists:especies,id',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);
    
        // Manejo de la imagen
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public'); // Guardamos la imagen en "storage/app/public/fotos"
            $validatedData['foto'] = asset('storage/' . $fotoPath); // Generamos la URL de acceso público
        } else {
            $validatedData['foto'] = null;
        }
    
        // Crear el registro
        $registro = Registro::create($validatedData);
    
        // Generar el código
        $especie = $registro->especie;
        $codigo = strtoupper(substr($especie->nombre, 0, 3)) . '-' . str_pad(count(Registro::where('especie_id', $registro->especie_id)->get()), 6, '0', STR_PAD_LEFT);
        $registro->codigo = $codigo;
        $registro->save();
    
        return response()->json(['message' => 'Registro creado correctamente', 'codigo' => $codigo], 201);
    }
    public function getByCodigo($codigo)
    {
        try {
            $registro = Registro::where('codigo', $codigo)->firstOrFail();
            return response()->json($registro, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
    }
    

    public function update(Request $request, $codigo)
    {
        // Validaciones
        $validatedData = $request->validate([
            'descripcionLaboratorio' => 'nullable|string',
            'resultado' => 'nullable|boolean',
        ]);
    
        // Buscar el registro por código
        $registro = Registro::where('codigo', $codigo)->first();
    
        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
    
        // Actualizar el registro
        $registro->update($validatedData);
    
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }
    
}
