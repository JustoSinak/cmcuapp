<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveillanceScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveillance_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('patient_id')->index();
            $table->dateTime('horaire');
            $table->string('ta');
            $table->string('fc');
            $table->integer('spo2');
            $table->integer('fr');
            $table->string('douleur')->nullable();
            $table->integer('temperature');
            $table->string('glycemie')->nullable();
            $table->string('sedation')->nullable();
            $table->string('nausee')->nullable();
            $table->string('vomissement')->nullable();
            $table->string('saignement')->nullable();
            $table->string('pansement')->nullable();
            $table->string('conscience')->nullable();
            $table->string('drains')->nullable();
            $table->string('miction')->nullable();
            $table->string('lever')->nullable();
            $table->string('score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveillance_scores');
    }
}
