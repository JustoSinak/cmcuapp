<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationSuivisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_suivis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->unsignedInteger('user_id')->index();
            $table->text('interrogatoire');
            $table->text('commentaire');
            $table->date('date_creation');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::dropIfExists('consultation_suivis');
    }
}
