<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Categoria extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si es 'categorias')
    protected $table = 'categorias';

    // Campos asignables
    protected $fillable = [
        'nombre',
        'descripcion', // opcional si la migración lo trae
    ];

    /**
     * Relación Many-to-Many con Producto.
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            Producto::class,
            'categoria_producto',
            'categoria_id',
            'producto_id'
        )->withTimestamps(); // opcional si la pivote tiene timestamps
    }
}