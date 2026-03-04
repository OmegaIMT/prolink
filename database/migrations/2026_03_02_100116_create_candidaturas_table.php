<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaga_id')->constrained('vagas')->cascadeOnDelete();
            $table->foreignId('profissional_id')->constrained('profissionais')->cascadeOnDelete();
            $table->string('link_acompanhamento')->nullable();
            $table->decimal('salario_proposto', 10, 2)->nullable();
            $table->date('data_aplicacao');
            $table->enum('status', [
                'aplicado',
                'entrevista',
                'proposta',
                'aprovado',
                'recusado'
            ])->default('aplicado');
            $table->text('observacao')->nullable();
            $table->text('beneficios')->nullable();
            $table->unique(['vaga_id', 'profissional_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidaturas');
    }
}
