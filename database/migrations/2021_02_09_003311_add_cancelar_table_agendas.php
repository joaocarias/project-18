<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelarTableAgendas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dateTime('data_desmarcacao')->nullable();

            $table->unsignedBigInteger('usuario_desmarcacao')->nullable();
            $table->foreign('usuario_desmarcacao')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn('data_desmarcacao');
            $table->dropColumn('usuario_desmarcacao');            
        });
    }
}
