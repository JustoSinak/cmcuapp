<?php

use Illuminate\support\Facades\schema;
use Illuminate\Database\schema\Blueprint;
use Illuminate\Database\migrations\migration;

class Createprescriptionstable extends migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->string('hematologie')->nullable();
            $table->string('hemostase')->nullable();
            $table->string('biochimie')->nullable();
            $table->string('hormonologie')->nullable();
            $table->string('marqueurs')->nullable();
            $table->string('bacteriologie')->nullable();
            $table->string('spermiologie')->nullable();
            $table->string('urines')->nullable();
            $table->string('serologie')->nullable();
            $table->string('examen')->nullable();
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
        schema::dropIfexists('prescriptions');
    }
}
