<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnProduitIdOnFicheConsommablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiche_consommables', function (Blueprint $table) {
            $table->dropColumn('produit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiche_consommables', function (Blueprint $table) {
            $table->unsignedInteger('produit_id')->index();
        });
    }
}
