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
        Schema::create('tarefa', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->enum('status',['A_Fazer','Fazendo','Pausado','Code_Review','Feito','Qualidade']);
            $table->string('total_horas',10)->nullable();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->unsignedBigInteger('historia_id');
            $table->foreign('historia_id')->references('id')->on('historia')->onDelete('cascade');
            $table->unsignedBigInteger('desenvolvedor_id');
            $table->foreign('desenvolvedor_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefa');
    }
};
