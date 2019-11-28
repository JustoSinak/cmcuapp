<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompteRenduBlocOperatoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_rendu_bloc_operatoires', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('patient_id')->index();
            $table->string('chirurgien');
            $table->string('aide_op');
            $table->string('anesthesiste');
            $table->string('infirmier_anesthesiste');
            $table->date('date_intervention');
            $table->time('dure_intervention');
            $table->text('compte_rendu_o');
            $table->text('indication_operatoire');
            $table->text('resultat_histo')->nullable();
            $table->text('suite_operatoire');
            $table->text('traitement_propose')->nullable();
            $table->text('soins')->nullable();
            $table->date('date_e');
            $table->date('date_s');
            $table->string('type_e');
            $table->string('type_s');
            $table->text('conclusion');
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
        Schema::dropIfExists('compte_rendu_bloc_operatoires');
    }
}
