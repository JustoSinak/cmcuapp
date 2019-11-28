<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnFactureConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facture_consultations', function (Blueprint $table) {
            $table->integer('avance')->nullable();
            $table->integer('reste')->nullable();
            $table->string('assurance')->nullable();
            $table->integer('assurancec')->nullable();
            $table->integer('assurec')->nullable();
            $table->string('demarcheur')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_insertion')->nullable();
            $table->integer('medecin_r')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *     * @return void
     */
    public function down()
    {
        Schema::table('facture_consultations', function (Blueprint $table) {
            $table->dropColumn('avance')->nullable();
            $table->dropColumn('reste')->nullable();
            $table->dropColumn('reste1')->nullable();
            $table->dropColumn('assurance')->nullable();
            $table->dropColumn('assurancec')->nullable();
            $table->dropColumn('assurec')->nullable();
            $table->dropColumn('demarcheur')->nullable();
            $table->dropColumn('prenom')->nullable();
            $table->dropColumn('date_insertion')->nullable();
            $table->integer('medecin_r')->nullable();
        });
    }
}
