<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'registros';

    protected $fillable = [
        'fecha',
        'longitud',
        'latitud',
        'foto',
        'codigo',
        'descripcionRegistro',
        'descripcionLaboratorio',
        'resultado',
        'especie_id',
        'usuario_id',
    ];

    public function especie(): BelongsTo
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
