<?php

use App\Http\Controllers\EspecieController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/usuarios',UsuarioController::class);
Route::apiResource('/especies', EspecieController::class);
Route::apiResource('/registros', RegistroController::class);

Route::post('/usuarios/login', [UsuarioController::class, 'login']);
Route::post('/usuarios/logout', [UsuarioController::class, 'logout']);
