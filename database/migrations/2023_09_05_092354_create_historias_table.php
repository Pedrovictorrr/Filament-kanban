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
        Schema::create('historia', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->date('data_previsao_cliente')->nullable();
            $table->date('data_previsao_qa')->nullable();
            $table->text('anexos')->nullable();
            $table->string('horas_previstas', 10)->nullable();
            $table->enum('prioridade', ['urgente', 'normal']);
            $table->enum('status', ['nova', 'andamento', 'liberar', 'concluido']);
            $table->unsignedBigInteger('tipo_historia');
            $table->foreign('tipo_historia')->references('id')->on('tipo_historia')->onDelete('cascade');
            $table->unsignedBigInteger('projeto_id');
            $table->foreign('projeto_id')->references('id')->on('projeto')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia');
    }
};
