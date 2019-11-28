<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imageries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->string('radiographie')->nullable();
            $table->string('echographie')->nullable();
            $table->string('scanner')->nullable();
            $table->string('irm')->nullable();
            $table->string('scintigraphie')->nullable();
            $table->string('autre')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('imageries');
    }
}
