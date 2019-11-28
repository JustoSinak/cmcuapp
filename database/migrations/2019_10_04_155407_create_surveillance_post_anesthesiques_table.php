<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveillancePostAnesthesiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveillance_post_anesthesiques', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('patient_id')->index();
            $table->string('surveillance')->nullable();
            $table->string('traitement')->nullable();
            $table->text('examen_paraclinique')->nullable();
            $table->string('observation')->nullable();
            $table->date('date_creation')->nullable();
            $table->date('date_sortie')->nullable();
            $table->time('heur_sortie')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveillance_post_anesthesiques');
    }
}
