<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponTableSeeder extends Seeder
{
    public function run()
    {
        // Cupón de Porcentaje
        Coupon::updateOrCreate(
            ['code' => 'DESCUENTO20'], // Condición de búsqueda
            [
                'type' => 'percent',
                'value' => 20.00,
                'min_order_price' => 10.00,
                'is_active' => true,
                'expires_at' => now()->addYears(1),
            ]
        );

        // Cupón Fijo
        Coupon::updateOrCreate(
            ['code' => 'FIJO5'], // Condición de búsqueda
            [
                'type' => 'fixed',
                'value' => 5.00,
                'min_order_price' => 20.00,
                'is_active' => true,
                'expires_at' => now()->addYears(1),
            ]
        );
    }
}