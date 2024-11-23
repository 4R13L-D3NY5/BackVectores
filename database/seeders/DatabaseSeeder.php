<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Rol::create([
            'nombre' => 'Administrador',
            'descripcion' => 'Acceso total al sistema.',
        ]);
        \App\Models\Usuario::create([
            'nombre' => 'admin',
            'password' => bcrypt('admin'),
            'rol_id' => 1,
        ]);

        \App\Models\Rol::create([
            'nombre' => 'Registrador',
            'descripcion' => 'Acceso a los módulos relacionados con el registro de evidencias de vectores.',
        ]);

        \App\Models\Rol::create([
            'nombre' => 'Laboratorio',
            'descripcion' => 'Acceso a los módulos relacionados con la validación de los registros de evidencias de vectores.',
        ]);

        \App\Models\Vector::create([
            'nombre' => 'Triatominos',
            'descripcion' => 'Los triatominos, también conocidos como "chinches besuconas" o "vinchucas", son insectos hematófagos (que se alimentan de sangre) pertenecientes a la familia Reduviidae.',
        ]);

        \App\Models\Especie::create([
            'nombre' => 'Vinchucas',
            'descripcion' => 'Las vinchucas, también conocidas como triatominos, son insectos de la familia Reduviidae, caracterizados por ser vectores del parásito Trypanosoma cruzi, causante de la enfermedad de Chagas.',
            'vector_id' => 1,
        ]);
    }
}
