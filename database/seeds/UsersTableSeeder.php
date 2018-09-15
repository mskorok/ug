<?php

use Database\Importers\UsersImporter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker =  Faker\Factory::create();

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        //$imgFaker = new \App\Helpers\ImageFaker();

        //$langs = ['en', 'de'];

        $users_importer = new UsersImporter;
        $users = $users_importer->parse();
        $max = $users_importer->count();


        for ($k = 0; $k < $max; $k++) {
            $activationDate = date('Y-m-d H:i:s');

            if (mt_rand(1, 2) == 1) {
                $activationDate = null;
            }

            $lat = $this->faker->latitude;
            $lng = $this->faker->longitude;

            DB::table('users')->insert([
                'profile_show_age' => mt_rand(0, 1),
                'gender_sid' => $users[$k]['gender_sid'],
                'categories_bit' => $users[$k]['categories_bit'],
                'email_notifications_bit' => mt_rand(0, 255),
                'alert_notifications_bit' => mt_rand(0, 255),

                'profile_locale' => 'de',

                //'first_name' => $faker->firstName,
                'name' => $users[$k]['name'],
                //'last_name' => $faker->lastName,
                //'last_name' => '',
                'email' => $users[$k]['email'],
                'password' => bcrypt('12345678'),
                //'photo_path' => $imgFaker->user(),
                'photo_path' => $users[$k]['photo_path'],
                //'about' => $faker->text,
                'about' => $users[$k]['about'],
                //'work' => $faker->sentence,
                'work' => $users[$k]['work'],
                'birth_date' => $users[$k]['birth_date'],

                'activation_code' => User::generateActivationCode(),
                'activated_at' => $activationDate,
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),

                //'hometown_name' => $this->faker->city,
                'hometown_name' => $users[$k]['hometown_name'],
                'hometown_id' => $this->faker->text(120),
                'hometown_location' => DB::raw('POINT('.$lat.', '.$lng.')'),
                //'country_name' => $this->faker->country,
            ]);
        }
    }
}
