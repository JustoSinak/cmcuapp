<?php

use Illuminate\Database\Seeder;
use App\Fiche;

class FichesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nom' => 'jerome',
                'prenom' => 'boateng',
                'chambre_numero' => '10',
                'age' => '20',
                'service' => 'urgence',
                'infirmier_charge' =>'emmanuel' ,
                'accueil' => 'EXCELLENT',
                'restauration' => 'excellent',
                'chambre' => 'bien',
                'soins' => 'bien',
                'notes' => '9',
                'quizz'=> 'oui',
                'remarque_suggestion' => 'le centre est tres cool et jaimerais aussi avoir le wifi en salle de reception'

            ],
            [
                'nom' => 'chafang',
                'prenom' => 'abdias',
                'chambre_numero' => '10',
                'age' => '20',
                'service' => 'urgence',
                'infirmier_charge' =>'emmanuel' ,
                'accueil' => 'EXCELLENT',
                'restauration' => 'excellent',
                'chambre' => 'bien',
                'soins' => 'bien',
                'notes' => '9',
                'quizz'=> 'oui',
                'remarque_suggestion' => 'le centre est tres cool et jaimerais aussi avoir le wifi en salle de reception'

            ],
            [
                'nom' => 'stephen',
                'prenom' => 'nkouamo',
                'chambre_numero' => '10',
                'age' => '20',
                'service' => 'urgence',
                'infirmier_charge' =>'emmanuel' ,
                'accueil' => 'EXCELLENT',
                'restauration' => 'excellent',
                'chambre' => 'bien',
                'soins' => 'bien',
                'notes' => '9',
                'quizz'=> 'oui',
                'remarque_suggestion' => 'le centre est tres cool et jaimerais aussi avoir le wifi en salle de reception'

            ],
            [
                'nom' => 'ewane',
                'prenom' => 'monic',
                'chambre_numero' => '10',
                'age' => '20',
                'service' => 'urgence',
                'infirmier_charge' =>'emmanuel' ,
                'accueil' => 'EXCELLENT',
                'restauration' => 'excellent',
                'chambre' => 'bien',
                'soins' => 'bien',
                'notes' => '9',
                'quizz'=> 'oui',
                'remarque_suggestion' => 'le centre est tres cool et jaimerais aussi avoir le wifi en salle de reception'

            ],

        ];
        foreach ($data as $key => $value) {

            Fiche::create($value);
        }
    }
}
