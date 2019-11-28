<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        //$this->call(ChambresTableSeeder::class);
        //$this->call(ProduitsTableSeeder::class);
        //$this->call(PatientsTableSeeder::class);
        //$this->call(FichesTableSeeder::class);
       // $this->call(DevisTableSeeder::class);
    }
}
