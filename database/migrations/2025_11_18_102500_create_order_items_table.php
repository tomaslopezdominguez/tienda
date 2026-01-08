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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Clave foránea a la tabla 'orders' con eliminación en cascada.
            // Esto asegura que si se borra un pedido, se borran sus ítems.
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            // Clave foránea a la tabla 'productos'. Usamos restrictOnDelete() 
            // para evitar borrar un producto si está en algún pedido.
            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->restrictOnDelete();

            $table->integer('cantidad')->default(1);
            $table->decimal('precio', 10, 2); // precio congelado al momento del pedido

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // En migraciones con foreign keys, se recomienda eliminar primero las
        // restricciones antes de eliminar la tabla.
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['producto_id']);
        });

        Schema::dropIfExists('order_items');
    }
};