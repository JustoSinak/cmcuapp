<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnJeunePreopOnConsultationAnesthesistesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultation_anesthesistes', function (Blueprint $table) {
            $table->dropColumn('jeune_preop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultation_anesthesistes', function (Blueprint $table) {
            $table->string('jeune_preop');
        });
    }
}
