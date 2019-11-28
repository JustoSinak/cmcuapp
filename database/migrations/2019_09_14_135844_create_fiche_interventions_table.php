<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFicheInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiche_interventions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('patient_id')->index();
            $table->string('nom_patient');
            $table->string('prenom_patient');
            $table->string('sexe_patient');
            $table->date('date_naiss_patient');
            $table->integer('portable_patient');
            $table->string('type_intervention');
            $table->time('dure_intervention');
            $table->string('position_patient');
            $table->string('decubitus')->nullable();
            $table->string('laterale')->nullable();
            $table->string('lombotomie')->nullable();
            $table->date('date_intervention');
            $table->string('medecin');
            $table->string('aide_op');
            $table->string('hospitalisation')->nullable();
            $table->string('ambulatoire')->nullable();
            $table->string('anesthesie');
            $table->text('recommendation')->nullable();
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
        Schema::dropIfExists('fiche_interventions');
    }
}
