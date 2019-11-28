<?php
use Illuminate\Database\Seeder;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = \App\User::create([
            'role_id' => '1',
            'name' => 'KOUAMO',
            'login' => 'sysadmin',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'homme',
            'prenom' => 'Stephane',
            'lieu_naissance' => 'Mbouda',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Admin2019@')
        ]);

        $user2 = \App\User::create([
            'role_id' => '8',
            'name' => 'MOUSSINGA',
            'prenom' => 'GENEVIEVE',
            'login' => 'GENEVIEVE',
            'telephone' => '694573129',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1979,01,03)->toDateTimeString(),
            'password' => bcrypt('qualite@cmcu2019')
        ]);

        $user3 = \App\User::create([
            'role_id' => '4',
            'name' => 'TOMDIO',
            'prenom' => 'PRISCA',
            'login' => 'TOMDIO',
            'telephone' => '654275011',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1985,10,05)->toDateTimeString(),
            'password' => bcrypt('Tomdio@2019')
        ]);

        $user3 = \App\User::create([
            'role_id' => '4',
            'name' => 'NOCHI FOUODJI',
            'prenom' => 'Edith',
            'login' => 'NOCHI FOUODJI',
            'telephone' => '654275251',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1985,10,05)->toDateTimeString(),
            'password' => bcrypt('Patient@2019')
        ]);

        $user4 = \App\User::create([
            'role_id' => '4',
            'name' => 'DEMGNE',
            'prenom' => 'VIVIANE',
            'login' => 'VIVIANE',
            'telephone' => '694259512',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Yaounde',
            'date_naissance' => \Carbon\Carbon::createFromDate(1989,05,28)->toDateTimeString(),
            'password' => bcrypt('infirmiere@2019')
        ]);

        $user44 = \App\User::create([
            'role_id' => '4',
            'name' => 'NGUMNJUEN',
            'prenom' => 'MOREEN',
            'login' => 'MOREEN',
            'telephone' => '673013211',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1987,12,31)->toDateTimeString(),
            'password' => bcrypt('infirmiere@2019')
        ]);

        $user45 = \App\User::create([
            'role_id' => '4',
            'name' => 'NOUGWAPI',
            'prenom' => 'SORELLE',
            'login' => 'SORELLE',
            'telephone' => '673013201',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1983,03,26)->toDateTimeString(),
            'password' => bcrypt('infirmiere@2019')
        ]);

        $user5 = \App\User::create([
            'role_id' => '4',
            'name' => 'NKANKO',
            'prenom' => 'LYNDA',
            'login' => 'NKANKO',
            'telephone' => '670014098',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Bafoussam',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,06,13)->toDateTimeString(),
            'password' => bcrypt('infirmiere@cmcu2019')
        ]);

        $user6 = \App\User::create([
            'role_id' => '4',
            'name' => 'TOUDJEU',
            'prenom' => 'RAÏSSA',
            'login' => 'TOUDJEU',
            'telephone' => '656635252',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1994,03,02)->toDateTimeString(),
            'password' => bcrypt('infirmiere@cmcu2019')
        ]);

        $user7 = \App\User::create([
            'role_id' => '4',
            'name' => 'NANA',
            'prenom' => 'DOMINIQUE',
            'login' => 'DOMINIQUE',
            'telephone' => '677761482',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Yaounde',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,11)->toDateTimeString(),
            'password' => bcrypt('infirmiere@cmcu2019')
        ]);

        $user8 = \App\User::create([
            'role_id' => '4',
            'name' => 'NGUMNJUEN',
            'prenom' => 'MOREEN',
            'login' => 'NGUMNJUEN',
            'telephone' => '673013200',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Njisse',
            'date_naissance' => \Carbon\Carbon::createFromDate(1985,05,28)->toDateTimeString(),
            'password' => bcrypt('infirmiere@cmcu2019')
        ]);

        $user9 = \App\User::create([
            'role_id' => '4',
            'name' => 'SEUTIO TCHOUBI',
            'prenom' => 'ROMEO',
            'login' => 'ROMEO SEUTIO',
            'telephone' => '694546170',
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Njisse',
            'date_naissance' => \Carbon\Carbon::createFromDate(1985,05,28)->toDateTimeString(),
            'password' => bcrypt('dOLIPRANE@2019')
        ]);

        $user10 = \App\User::create([
            'role_id' => '2',
            'name' => 'NJINOU NGNINKEU',
            'prenom' => 'Bertin',
            'login' => 'NJINOU',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Douala',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Njinou@2019')
        ]);

        $user11 = \App\User::create([
            'role_id' => '2',
            'name' => 'KAMADJOU',
            'prenom' => 'Cyril',
            'login' => 'KAMADJOU',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Douala',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Kamadjou@2019')
        ]);

        $user12 = \App\User::create([
            'role_id' => '2',
            'name' => 'TENKE',
            'prenom' => 'Christelle',
            'login' => 'TENKE',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'specialite' => 'Anesthésiste',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Tenke@2019')
        ]);

        $user13 = \App\User::create([
            'role_id' => '2',
            'name' => 'KUITCHE',
            'prenom' => 'Jerry',
            'login' => 'KUITCHE',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Douala',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '7858',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Kuitche@2019')
        ]);

        $user14 = \App\User::create([
            'role_id' => '2',
            'name' => 'DJOUFANG',
            'prenom' => 'Rodrigue',
            'login' => 'DJOUFANG',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Douala',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Djoufang@2019')
        ]);

        $user15 = \App\User::create([
            'role_id' => '2',
            'name' => 'MAKON',
            'prenom' => 'Stéphane',
            'login' => 'MAKON',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Douala',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Makon@2019')
        ]);

        $user16 = \App\User::create([
            'role_id' => '2',
            'name' => 'NGANDEU',
            'prenom' => 'Marcel Jerry',
            'login' => 'NGANDEU',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Douala',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1990,01,01)->toDateTimeString(),
            'password' => bcrypt('Ngandeu@2019')
        ]);

        $user17 = \App\User::create([
            'role_id' => '2',
            'name' => 'NTEHJOUEN',
            'prenom' => 'Aminatou',
            'login' => 'NTEHJOUEN',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Foumbot',
            'specialite' => 'Médecin généraliste',
            'onmc' => '7175',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Ntehjouen@2019')
        ]);

        $user18 = \App\User::create([
            'role_id' => '2',
            'name' => 'KEMEZE',
            'prenom' => 'Sandrine',
            'login' => 'KEMEZE',
            'telephone' => '697112288',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Médecin généraliste',
            'onmc' => '8014',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Kemeze@2019')
        ]);

        $user19 = \App\User::create([
            'role_id' => '2',
            'name' => 'NGAYAP',
            'prenom' => 'FRANK',
            'login' => 'NGAYAP',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Médecin généraliste',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Ngayap@2019')
        ]);

        $user20 = \App\User::create([
            'role_id' => '2',
            'name' => 'TCHIEJI',
            'prenom' => 'Audrey',
            'login' => 'TCHIEJI',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Médecin de travail',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Tchieji@2019')
        ]);

        $user21 = \App\User::create([
            'role_id' => '2',
            'name' => 'HAPPI',
            'prenom' => 'Mireille',
            'login' => 'HAPPI',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Pédiatre',
            'onmc' => '4609',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Happi@2019')
        ]);

        $user2001 = \App\User::create([
            'role_id' => '2',
            'name' => 'SANDJON',
            'prenom' => 'Jean Paul',
            'login' => 'SANDJON',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'ANESTHESISTE',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Sandjon@2019')
        ]);

        $user2101 = \App\User::create([
            'role_id' => '2',
            'name' => 'EYOMGETA',
            'prenom' => 'Divine',
            'login' => 'EYOMGETA',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Eyomgeta@2019')
        ]);

        $user21041 = \App\User::create([
            'role_id' => '2',
            'name' => 'TOUKAM',
            'prenom' => 'Eve',
            'login' => 'TOUKAM',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Toukam@2019')
        ]);

        $user29041 = \App\User::create([
            'role_id' => '2',
            'name' => 'CHENDJOU',
            'prenom' => 'Brice',
            'login' => 'CHENDJOU',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('Chendjou@2019')
        ]);

        $user29041 = \App\User::create([
            'role_id' => '2',
            'name' => 'EPOUPA NGALLE',
            'prenom' => 'Franck',
            'login' => 'EPOUPA',
            'telephone' => mt_rand(10000000, 99999999),
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Yaounde',
            'specialite' => 'Chirurgien urologue',
            'onmc' => '0000',
            'date_naissance' => \Carbon\Carbon::createFromDate(1984,11,30)->toDateTimeString(),
            'password' => bcrypt('ENFranck@2019')
        ]);

        $user22 = \App\User::create([
            'role_id' => '3',
            'name' => 'ENDALE TITI',
            'prenom' => 'AMELIE',
            'login' => 'TITI',
            'telephone' => '699838118',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1980,12,15)->toDateTimeString(),
            'password' => bcrypt('Titi@2019')
        ]);

        $user22 = \App\User::create([
            'role_id' => '6',
            'name' => 'ETINDELE',
            'prenom' => 'SANDRINE',
            'login' => 'ETINDELE',
            'telephone' => '000001000',
            'sexe' => 'Féminin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1980,12,15)->toDateTimeString(),
            'password' => bcrypt('Etindele@2019')
        ]);

        $user221 = \App\User::create([
            'role_id' => '9',
            'name' => 'NDOUMBE',
            'prenom' => 'CHRISTIAN',
            'login' => 'NDOUMBE',
            'telephone' => '000020000',
            'sexe' => 'Masculin',
            'lieu_naissance' => 'Douala',
            'date_naissance' => \Carbon\Carbon::createFromDate(1980,12,15)->toDateTimeString(),
            'password' => bcrypt('Compta@2019')
        ]);




//        $user1 = User::findOrFail(1);
//        $user1->roles()->attach(\App\Role::where('name', 'ADMINISTRATEUR')->first());
    }
}