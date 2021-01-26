<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            $table->dateTime('data')->nullable();

            $table->unsignedBigInteger('profissional_id')->nullable();
            $table->foreign('profissional_id')->references('id')->on('profissionals'); 

            $table->unsignedBigInteger('paciente_id')->nullable();
            $table->foreign('paciente_id')->references('id')->on('pacientes'); 

            $table->dateTime('data_agendamento')->nullable();

            $table->unsignedBigInteger('usuario_agendamento')->nullable();
            $table->foreign('usuario_agendamento')->references('id')->on('users');

            $table->unsignedBigInteger('usuario_cadastro');
            $table->foreign('usuario_cadastro')->references('id')->on('users');

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
        Schema::dropIfExists('agendas');
    }
}
