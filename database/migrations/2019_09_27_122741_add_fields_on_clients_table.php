<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
           $table->integer('partassurance')->nullable();
            $table->integer('partpatient')->nullable();
            $table->integer('assurance')->nullable();
            $table->string('demarcheur')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('prise_en_charge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('numero_assurance')->nullable();
            $table->string('prise_en_charge')->nullable();
            $table->dropColumn('assurance')->nullable();
            $table->dropColumn('partassurance')->nullable();
            $table->dropColumn('partpatient')->nullable();
            $table->dropColumn('demarcheur')->nullable();
          
        });
    }
}
