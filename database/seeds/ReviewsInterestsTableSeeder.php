<?php

use Database\Importers\ActivitiesImporter;
use Database\Importers\InterestsImporter;
use Database\Importers\ReviewsImporter;
use Database\Importers\UsersImporter;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ReviewsInterestsTableSeeder extends Seeder
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

        $reviews_importer = new ReviewsImporter;
        $reviews = $reviews_importer->parse();
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

        foreach ($reviews as $review) {
            foreach ($review['interests'] as $interest_id) {
                $data[] = [
                    'interest_id' => $interest_id,
                    'review_id' => $review['id'],
                ];
            }
        }

        DB::table('interest_review')->insert($data);
    }
}
