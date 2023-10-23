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
        Schema::create('tempo_gasto', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->string('horas_gastas',10);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->onDelete('cascade')->on('users');
            $table->unsignedBigInteger('tarefa_id');
            $table->foreign('tarefa_id')->references('id')->onDelete('cascade')->on('tarefa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempo_gasto');
    }
};
