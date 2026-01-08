<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'posicion',
        'imagen', // <-- ¡NUEVO CAMPO AÑADIDO!
    ];

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto', 'producto_id', 'categoria_id')->withTimestamps();
    }

    /**
     * Relación con order items (si tienes tabla order_items).
     * Ajusta el nombre del modelo / tabla si usas otros nombres.
     */
    public function orderItems()
    {
        // Si tu modelo se llama OrderItem y la fk en order_items es producto_id:
        return $this->hasMany(\App\Models\OrderItem::class, 'producto_id');
    }
    
}