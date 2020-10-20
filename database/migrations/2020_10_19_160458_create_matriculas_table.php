<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_aluno');
            $table->integer('id_turma');
            $table->double('nota_primeiro_bimestre');
            $table->double('nota_segundo_bimestre');
            $table->double('nota_terceiro_bimestre');
            $table->double('nota_quarto_bimestre');
            $table->timestamps();

            $table->foreign('id_turma')->references('id')->on('turmas');
            $table->foreign('id_aluno')->references('id')->on('alunos');
            $table->unique(['id_aluno', 'id_turma']);
            $table->unique('id_aluno');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
