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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->date('fecha_entrada')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->string('movimiento');
            $table->string('motivo');
            $table->integer('cantidad'); //stock actual
            $table->integer('cantidad_movimiento')->nullable(); //cantidad de productos que se agregan o se quitan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
