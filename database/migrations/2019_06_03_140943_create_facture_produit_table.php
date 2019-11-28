<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactureProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_produit', function (Blueprint $table) {

            $table->primary(['facture_id', 'produit_id']);

            $table->unsignedInteger('facture_id');
            $table->unsignedInteger('produit_id');
            $table->integer('item');
            $table->integer('prix_unitaire');
            $table->integer('quantite');
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
        Schema::dropIfExists('facture_produit');
    }
}
