<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// IMPORTS explícitos
use App\Models\Order;
use App\Models\Producto;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'producto_id',
        'cantidad',
        'precio',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
