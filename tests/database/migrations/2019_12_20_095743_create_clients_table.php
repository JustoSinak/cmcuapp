<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id')->nullable();
			$table->string('nom');
			$table->string('prenom')->nullable();
			$table->string('motif')->nullable();
			$table->integer('montant')->nullable();
			$table->integer('avance')->nullable();
			$table->integer('reste')->nullable();
			$table->timestamps();
			$table->integer('partassurance')->nullable();
			$table->integer('partpatient')->nullable();
			$table->integer('assurance')->nullable();
			$table->string('demarcheur')->nullable();
			$table->string('numero_assurance')->nullable();
			$table->string('prise_en_charge')->nullable();
			$table->string('date_insertion')->nullable();
			$table->string('medecin_r')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}

}
