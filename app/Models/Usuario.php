<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'password',
        'estado',
        'nombres',
        'apellidos',
        'ci',
        'telefono',
        'rol_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function registros()
    {
        return $this->hasMany(Registro::class, 'usuario_id');
    }
}
