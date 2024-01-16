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
        Schema::create('customers', function (Blueprint $table) {
            /* $table->id(); */
            $table->string('dni')->primary()->comment('Documento de Identidad');
            $table->string('email')->comment('Correo Electrónico');
            $table->string('name')->comment('Nombre');;
            $table->string('last_name')->comment('Apellido');;
            $table->string('address')->comment('Dirección');;
            $table->enum('status', ['A', 'I','Trash'])->default('A')->comment('Estado del registro: A: Activo. I : Desactivo. Trash : Registro eliminado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
