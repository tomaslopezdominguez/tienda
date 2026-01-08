<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     * Incluimos 'name' y 'slug'.
     * @var array
     */
    protected $fillable = ['name', 'slug']; // <-- ¡'slug' añadido!

    /**
     * Obtiene los usuarios que tienen este rol (Relación Many-to-Many).
     */
    public function users(): BelongsToMany
    {
        // Un rol puede tener muchos usuarios.
        return $this->belongsToMany(User::class);
    }
}

