<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->float('poids');
            $table->float('taille');
            $table->string('bras_gauche');
            $table->string('bras_droit');
            $table->string('inc_bmi');
            $table->date('date_naissance');
            $table->integer('age');
            $table->string('temperature');
            $table->string('fr')->nullable();
            $table->string('fc')->nullable();
            $table->string('spo2')->nullable();
            $table->string('glycemie')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametres');
    }
}
