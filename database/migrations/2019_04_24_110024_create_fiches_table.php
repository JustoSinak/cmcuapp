<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichesTable extends Migration
{

    public function up()
    {
        Schema::create('fiches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('chambre_numero');
            $table->integer('age');
            $table->string('service');
            $table->string('infirmier_charge');
            $table->string('accueil');
            $table->string('restauration');
            $table->string('chambre');
            $table->string('soins');
            $table->integer('notes');
            $table->string('quizz');
            $table->string('remarque_suggestion');
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
        Schema::dropIfExists('fiches');
    }
}
