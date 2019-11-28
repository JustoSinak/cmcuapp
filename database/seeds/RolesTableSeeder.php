<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = \App\Role::create([
            'name' => 'ADMINISTRATEUR',
        ]);

        $role2 = \App\Role::create([
            'name' => 'MEDECIN',
        ]);

        $role3 = \App\Role::create([
            'name' => 'GESTIONNAIRE',
        ]);

        $role4 = \App\Role::create([
            'name' => 'INFIRMIER',
        ]);

        $role5 = \App\Role::create([
            'name' => 'LOGISTIQUE',
        ]);

        $role6 = \App\Role::create([
            'name' => 'SECRETAIRE',
        ]);

        $role7 = \App\Role::create([
            'name' => 'PHARMACIEN',
        ]);

        $role8 = \App\Role::create([
            'name' => 'QUALITE',
        ]);

        $role9 = \App\Role::create([
            'name' => 'COMPTABLE',
        ]);

    }
}
