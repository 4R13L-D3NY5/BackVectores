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
            'foto' => 'nullable|string',            
            'descripcionRegistro' => 'nullable|string',            
            'especie_id' => 'required|exists:especies,id',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        // Crear el registro
        $registro = Registro::create($validatedData);
        $especie = $registro->especie;
        $codigo = strtoupper(substr($especie->nombre, 0, 3)) . '-' . str_pad(count(Registro::where('especie_id', $registro->especie_id)->get()), 6, '0', STR_PAD_LEFT);
        $registro->codigo = $codigo;
        $registro->save();
        return response()->json(['message' => 'Registro creado correctamente'], 201);
    }
    public function update(Request $request)
    {
        // Validaciones
        $validatedData = $request->validate([
            'id' => 'required|exists:registros,id',
            'descripcionLaboratorio' => 'nullable|string',
            'resultado' => 'nullable|boolean',
        ]);

        // Buscar y actualizar el registro
        $registro = Registro::find($validatedData['id']);

        $registro->update($validatedData);

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }
}
