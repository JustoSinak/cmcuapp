<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnCompteRenduBlocOperatoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compte_rendu_bloc_operatoires', function (Blueprint $table) {
            
            $table->string('type_intervention')->nullable();
            $table->string('titre_intervention')->nullable();
            $table->string('proposition_suivi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compte_rendu_bloc_operatoires', function (Blueprint $table) {
            
            $table->dropColumn(['type_intervention', 'titre_intervention', 'proposition_suivi']);
        });
    }
}
