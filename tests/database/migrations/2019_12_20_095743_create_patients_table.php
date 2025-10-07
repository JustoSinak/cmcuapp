<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patients', function(Blueprint $table)
		{
			$table->integer('id', true, true);
			$table->integer('user_id');
			$table->integer('numero_dossier')->unique();
			$table->string('name')->unique();
			$table->string('assurance')->nullable();
			$table->string('numero_assurance')->nullable();
			$table->string('prise_en_charge')->nullable();
			$table->timestamps();
			$table->integer('reste')->nullable();
			$table->integer('assurancec')->nullable();
			$table->integer('assurec')->nullable();
			$table->string('demarcheur')->nullable();
			$table->string('motif')->nullable();
			$table->string('prenom')->nullable();
			$table->date('date_insertion')->nullable();
			$table->integer('montant')->nullable();
			$table->integer('avance')->nullable();
			$table->integer('medecin_r')->nullable();
			$table->text('details_motif')->nullable()->default('Consultation');

			// Newly added indexes for performance optimization
			// Indexes 
			$table->index('user_id'); // Foreign key index
            $table->index(['name', 'prenom']); // Composite index for search queries
            $table->index('date_insertion'); // For date-based queries
            $table->index('medecin_r'); // Frequently filtered column
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patients');
	}

}
