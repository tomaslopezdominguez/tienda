<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Añadir columna para el descuento (valor monetario)
            $table->decimal('discount', 8, 2)->default(0)->after('total'); 
            // Añadir columna para guardar el código de cupón usado
            $table->string('coupon_code')->nullable()->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Eliminar las columnas si se revierte la migración
            $table->dropColumn(['discount', 'coupon_code']);
        });
    }
};