<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevisImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->string('devis_p');
            $table->string('image');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('devis_images');
    }
}


