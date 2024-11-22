<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vector extends Model
{
    use HasFactory;

    protected $table = 'vectors';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function especies(): HasMany
    {
        return $this->hasMany(Especie::class, 'vector_id');
    }
}
