<?php


use Database\Importers\UsersImporter;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersLanguagesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_count = (new UsersImporter)->count();
        $lang_count = 184;
        $min_lang_count = 1;
        $max_lang_count = 4;

        $faker = Factory::create();

        $data = [];

        for ($i = 0; $i < $user_count; $i++) {
            $user_lang_count = mt_rand($min_lang_count, $max_lang_count);
            for ($i2 = 0; $i2 < $user_lang_count; $i2++) {
                $data[] = [
                    'user_id' => $i+1,
                    'language_id' => $faker->unique()->numberBetween(1, $lang_count),
                ];
            }
        }

        DB::table('users_languages')->insert($data);
    }

}
