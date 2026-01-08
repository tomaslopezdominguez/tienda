<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Código del cupón (ej. VERANO25)
            $table->enum('type', ['fixed', 'percent']); // Tipo de descuento
            $table->decimal('value', 8, 2); // Valor del descuento (ej. 25 o 10.00)
            $table->decimal('min_order_price', 8, 2)->default(0); // Precio mínimo del carrito
            $table->timestamp('expires_at')->nullable(); // Fecha de expiración
            // Para el rango de fechas, solo usaremos expires_at por simplicidad,
            // pero puedes añadir 'starts_at' si lo necesitas.
            $table->boolean('is_active')->default(true); // Control administrativo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};