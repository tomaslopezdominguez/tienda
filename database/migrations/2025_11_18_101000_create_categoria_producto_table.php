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
        // El nombre de la tabla debe seguir el orden alfabético de los modelos:
        Schema::create('categoria_producto', function (Blueprint $table) {
            
            // FK a la tabla 'productos'.
            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->cascadeOnDelete();

            // FK a la tabla 'categorias'.
            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->cascadeOnDelete();
            
            // Se activan los Timestamps para coincidir con el Modelo Producto.php
            $table->timestamps(); 

            // PK compuesta evita duplicados
            $table->primary(['producto_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_producto');
    }
};