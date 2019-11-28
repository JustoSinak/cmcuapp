<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->index();
            $table->unsignedInteger('user_id')->index();
           
            $table->text('diagnostic');
            $table->text('interrogatoire');
            $table->text('antecedent_m')->nullable();
            $table->text('antecedent_c')->nullable();
            $table->string('medecin_r');
            $table->text('allergie')->nullable();
            $table->string('groupe')->nullable();
            $table->string('proposition_therapeutique');
            $table->string('proposition');
            $table->text('examen_p')->nullable();
            $table->text('examen_c')->nullable();
            $table->text('motif_c')->nullable();
            $table->date('date_intervention')->nullable();
            $table->date('date_consultation')->nullable();
            $table->date('date_consultation_anesthesiste')->nullable();
            $table->string('acte')->nullable();
            $table->string('devis_p')->nullable();
            $table->string('type_intervention')->nullable();
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
        Schema::dropIfExists('consultations');
    }
}
