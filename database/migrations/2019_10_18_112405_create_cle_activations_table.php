<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCleActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cle_activations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('licence_id')->index()->nullable();
            $table->string('secret');
            $table->integer('type');
            $table->boolean('statut');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cle_activations');
    }
}
