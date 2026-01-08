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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Relación con la tabla 'users' (asumiendo que los pedidos son de usuarios)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('status')->default('pending'); // Ej: pending, paid, shipped
            
            // AÑADIDO: Columna necesaria para solucionar el error
            $table->string('metodo_pago')->default('manual');
            
            $table->decimal('total', 10, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};