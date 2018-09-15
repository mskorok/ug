<?php

use Database\Importers\ActivitiesImporter;
use Database\Importers\InterestsImporter;
use Database\Importers\UsersImporter;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ActivitiesInterestsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interests_importer = new InterestsImporter;
        $interests = $interests_importer->parse();
        //$interests_count = $interests_importer->count();

        $activities_importer = new ActivitiesImporter;
        $activities = $activities_importer->parse();
        //$users_count = $users_importer->count();

        //$min_interests = 1;
        //$max_interests = 4;

        /*$faker = Factory::create();

        $data = [];
        for ($k = 0; $k < $users_count; $k++) {
            $user_has_interests_count = mt_rand($min_interests, $max_interests);
            for ($k2 = 0; $k2 < $user_has_interests_count; $k2++) {
                $data[] = [
                    'interest_id' => $faker->unique()->numberBetween(1, $interests_count),

                    'user_id' => $k+1,
                ];
            }

        }*/

        $data = [];

        foreach ($activities as $activity) {
            foreach ($activity['interests'] as $interest_id) {
                $data[] = [
                    'interest_id' => $interest_id,
                    'adventure_id' => $activity['id'],
                ];
            }
        }

        DB::table('adventure_interest')->insert($data);
    }
}
