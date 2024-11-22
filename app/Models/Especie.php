<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especie extends Model
{
    use HasFactory;

    protected $table = 'especies';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'vector_id',
    ];

    public function vector(): BelongsTo
    {
        return $this->belongsTo(Vector::class, 'vector_id');
    }

    public function registros(): HasMany
    {
        return $this->hasMany(Registro::class, 'especie_id');
    }
}

