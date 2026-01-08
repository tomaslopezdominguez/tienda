<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('alias')->nullable(); // Ej: "Casa", "Oficina"
            $table->string('recipient_name')->nullable(); // Nombre de quien recibe
            $table->string('line_1'); // Calle y número
            $table->string('line_2')->nullable(); // Depto, piso, etc.
            $table->string('city');
            $table->string('state')->nullable(); // Provincia/Estado
            $table->string('postal_code');
            $table->string('country')->default('España'); // Por defecto, si es tienda local
            $table->boolean('is_primary')->default(false); // Dirección por defecto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};