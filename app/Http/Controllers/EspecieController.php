<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use Illuminate\Http\Request;

class EspecieController extends Controller
{
    //
    public function index()
    {
        $especies = Especie::with('vector')->get();
        return response()->json(['especies' => $especies], 201);
    }
}
