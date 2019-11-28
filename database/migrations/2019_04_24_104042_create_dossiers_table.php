<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDossiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('patient_id')->index();
            $table->string('sexe');
            $table->string('personne_confiance')->nullable();
            $table->integer('tel_personne_confiance')->nullable();
            $table->integer('portable_1')->nullable();
            $table->integer('portable_2')->nullable();
            $table->string('personne_contact')->nullable();
            $table->integer('tel_personne_contact')->nullable();
            $table->string('profession')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('adresse')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->date('date_naissance')->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('dossiers');
    }
}
