<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'metodo_pago',
        // --- CAMPOS AÑADIDOS PARA CUPONES/DESCUENTO ---
        'discount',         
        'coupon_code',      
        // --- FIN CAMPOS AÑADIDOS ---
    ];
    


    /**
     * Relación: Un pedido pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Un pedido tiene múltiples items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}