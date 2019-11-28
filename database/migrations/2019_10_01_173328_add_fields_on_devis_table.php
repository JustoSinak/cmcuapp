<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsOnDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->integer('qte12')->nullable();
            $table->integer('qte13')->nullable();
            $table->integer('qte14')->nullable();
            $table->integer('prix_u11')->nullable();
            $table->integer('prix_u12')->nullable();
            $table->integer('prix_u13')->nullable();
            $table->integer('montant12')->nullable();
            $table->integer('montant13')->nullable();
            $table->integer('montant14')->nullable();
            $table->string('elements11')->nullable();
            $table->string('elements12')->nullable();
            $table->string('elements13')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropColumn('qte12');
            $table->dropColumn('qte13');
            $table->dropColumn('qte14');
            $table->dropColumn('prix_u11');
            $table->dropColumn('prix_u12');
            $table->dropColumn('prix_u13');
            $table->dropColumn('montant12');
            $table->dropColumn('montant13');
            $table->dropColumn('montant14');
            $table->dropColumn('elements11');
            $table->dropColumn('elements12');
            $table->dropColumn('elements13');
        });
    }
}
