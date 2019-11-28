<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnFactureClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facture_clients', function (Blueprint $table) {
            $table->integer('partassurance')->nullable();
            $table->integer('partpatient')->nullable();
            $table->integer('assurance')->nullable();
            $table->string('demarcheur')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('prise_en_charge')->nullable();
            $table->string('date_insertion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facture_clients', function (Blueprint $table) {
            $table->dropColumn('demarcheur');
          
        });
    }
}
