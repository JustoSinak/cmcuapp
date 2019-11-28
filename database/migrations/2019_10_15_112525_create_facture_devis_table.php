<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactureDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_devis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('patient_id')->index();
            $table->string('designation_devis');
            $table->integer('numero_facture');
            $table->integer('montant_devis');
            $table->integer('avance_devis')->nullable();
            $table->integer('reste_devis')->nullable();
            $table->integer('part_assurance')->nullable();
            $table->integer('part_patient')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('assurance')->nullable();
            $table->integer('taux_assurance')->nullable();
            $table->date('date_creation');
            $table->string('type_paiement')->nullable();
            $table->string('numero_cheque')->nullable();
            $table->string('tireur_cheque')->nullable();
            $table->string('banque_emission')->nullable();
            $table->date('date_emission')->nullable();
            $table->string('attestation_virement')->nullable();
            $table->string('numero_compte')->nullable();
            $table->integer('montant_virement')->nullable();
            $table->string('banque_virement')->nullable();
            $table->date('date_virement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facture_devis');
    }
}
