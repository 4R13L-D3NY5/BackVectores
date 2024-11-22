<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del usuario
            $table->string('password'); // Contraseña del usuario
            $table->integer('estado')->default(1); // Estado del usuario (activo/inactivo)
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('ci')->nullable();
            $table->string('telefono')->nullable();
            
            $table->unsignedBigInteger('rol_id'); // Relación con la tabla roles
            // Relaciones
            $table->foreign('rol_id')->references('id')->on('rols');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};