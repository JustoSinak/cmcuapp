<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add index on user_id for faster lookups
            $table->index('user_id');
            // Add composite index on name and prenom for search optimization
            $table->index(['name', 'prenom']);
        });

        Schema::table('consultations', function (Blueprint $table) {
            // Add index on patient_id foreign key
            $table->index('patient_id');
        });

        Schema::table('factures', function (Blueprint $table) {
            // Add index on patient_id foreign key
            $table->index('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['name', 'prenom']);
        });

        Schema::table('consultations', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
        });

        Schema::table('factures', function (Blueprint $table) {
            $table->dropIndex(['patient_id']);
        });
    }
}
