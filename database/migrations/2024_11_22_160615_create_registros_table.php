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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('longitud', 15, 12);
            $table->decimal('latitud', 15, 12);
            $table->string('foto')->nullable();
            $table->string('codigo')->nullable();
            $table->text('descripcionRegistro')->nullable();
            $table->string('descripcionLaboratorio')->nullable();
            $table->boolean('resultado')->nullable();

            $table->unsignedBigInteger('especie_id');
            $table->foreign('especie_id')->references('id')->on('especies');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
