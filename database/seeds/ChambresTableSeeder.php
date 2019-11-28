<?php

use Illuminate\Database\Seeder;
use App\Chambre;

class ChambresTableSeeder extends Seeder
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
                'user_id'       => '5',
                'numero'       => '101 Lit 1',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '101 Lit 2',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '102 Lit 1',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '102 Lit 2',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '103 Lit 1',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '103 Lit 2',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '104 Lit 1',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '104 Lit 2',
                'categorie'       => 'CLASSIQUE',
                'patient'       => 'null',
                'prix'       => '50000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => '105',
                'categorie'       => 'VIP',
                'patient'       => 'null',
                'prix'       => '100000',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => 'BLOC 1',
                'categorie'       => 'BLOC OPERATOIRE',
                'patient'       => 'null',
                'statut'       => 'libre',
            ],
            [
                'user_id'       => '5',
                'numero'       => 'BLOC 2',
                'categorie'       => 'BLOC OPERATOIRE',
                'patient'       => 'null',
                'statut'       => 'libre',
            ] 
            

        ];
        foreach ($data as $key => $value) {

            Chambre::create($value);
        }
    }
}
