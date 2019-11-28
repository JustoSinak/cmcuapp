<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            
            // devis orchidectomie bilaterale
            $table->increments('id');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->unsignedInteger('patient_id')->index()->nullable();
           
            $table->string('nom')->unique();
            $table->integer('qte1')->nullable();
            $table->integer('qte2')->nullable()->default(1);
            $table->integer('qte3')->nullable()->default(1);
            $table->integer('qte4')->nullable()->default(1);
            $table->string('qte5')->nullable()->default(1);
            $table->string('qte6')->nullable()->default(1);
            $table->string('qte7')->nullable()->default(1);
            $table->integer('qte8')->nullable();
            $table->integer('qte9')->nullable();
            $table->integer('qte10')->nullable();
            $table->integer('qte11')->nullable();
            $table->integer('prix_u')->nullable();
            $table->integer('prix_u1')->nullable();
            $table->integer('prix_u2')->nullable();
            $table->integer('prix_u3')->nullable();
            $table->integer('prix_u4')->nullable();
            $table->integer('prix_u5')->nullable();
            $table->integer('prix_u6')->nullable();
            $table->integer('prix_u7')->nullable();
            $table->integer('prix_u8')->nullable();
            $table->integer('prix_u9')->nullable();
            $table->integer('prix_u10')->nullable();
            $table->integer('montant')->nullable();
            $table->integer('montant1')->nullable();
            $table->integer('montant2')->nullable();
            $table->integer('montant3')->nullable();
            $table->integer('montant4')->nullable();
            $table->integer('montant5')->nullable();
            $table->integer('montant6')->nullable();
            $table->integer('montant7')->nullable();
            $table->integer('montant8')->nullable();
            $table->integer('montant9')->nullable();
            $table->integer('montant10')->nullable();
            $table->integer('montant11')->nullable();
            $table->string('elements')->nullable();
            $table->string('elements1')->nullable();
            $table->string('elements2')->nullable();
            $table->string('elements3')->nullable();
            $table->string('elements4')->nullable();
            $table->string('elements5')->nullable();
            $table->string('elements6')->nullable();
            $table->string('elements7')->nullable();
            $table->string('elements8')->nullable();
            $table->string('elements9')->nullable();
            $table->string('elements10')->nullable();
            $table->string('arreter')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('devis');
    }
}
