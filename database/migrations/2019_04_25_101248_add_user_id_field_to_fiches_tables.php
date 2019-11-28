<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdFieldToFichesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiches', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned()->nullable()->after('id');
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiches', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('patient_id');
        });
    }
}
