<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_price',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'min_order_price' => 'float',
        'value' => 'float',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Determina si el cupón está activo y dentro del rango de fechas.
     */
    public function isValid()
    {
        // 1. Comprobar si está marcado como activo
        if (!$this->is_active) {
            return false;
        }

        // 2. Comprobar si ha expirado
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Si pasa ambas comprobaciones, es válido por defecto
        return true;
    }
}