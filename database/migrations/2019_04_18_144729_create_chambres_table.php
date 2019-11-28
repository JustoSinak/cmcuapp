<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChambresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chambres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('numero');
            $table->string('categorie');
            $table->string('patient')->nullable()->default('Vide');
            $table->integer('prix')->nullable();
            $table->integer('jour')->nullable();
            $table->enum('statut', ['libre', 'occupé'])->default('libre');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

    }
    public function down()
    {
        Schema::dropIfExists('chambres');
    }
}
