<?php

use Database\Importers\ReviewsImporter;
use Database\Importers\UsersImporter;
use Illuminate\Database\Seeder;

/**
 * Class ReviewsTableSeeder
 */
class ReviewsTableSeeder extends Seeder
{
    protected $faker;
    protected $imgFaker;

    /**
     * ReviewsTableSeeder constructor.
     */
    public function __construct()
    {
        $this->faker =  Faker\Factory::create('de_DE');
        $this->imgFaker = new \App\Helpers\ImageFaker();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importer = new ReviewsImporter;
        $reviews = $importer->parse();
        $reviews_count = $importer->count();
        $users_count = (new UsersImporter)->count();

        for ($k = 0; $k < $reviews_count; $k++) {
            $lat = $this->faker->latitude;
            $lng = $this->faker->longitude;
            //$title = $this->faker->catchPhrase;
            $title = $reviews[$k]['title'];

            $gallery = [];
            for ($j = 0; $j < mt_rand(4, 20); $j++) {
                $gallery[] = $this->imgFaker->activity();
            }

            $recommended = [];
            for ($j = 0; $j < mt_rand(1, $users_count); $j++) {
                $recommended[] = $j + 1;
            }

            $liked = [];
            for ($j = 0; $j < mt_rand(1, $users_count); $j++) {
                $liked[] = $j + 1;
            }

            DB::table('reviews')->insert([
                //'user_id'               => mt_rand(1, 200),
                'user_id'               => $reviews[$k]['user_id'],
                //'category_sid'       => mt_rand(0, 7),
                'category_sid'          => $reviews[$k]['category_sid'],
                'gallery'               => json_encode($gallery),
                //'promo_image'           => $promo_image,
                'promo_image'           => $reviews[$k]['promo_image'],
                'place_id'              => $this->faker->text(120),
                'like_count'            => count($liked),
                'recommend_count'       => count($recommended),
                //'place_name'            => $this->faker->city,
                'place_name'            => $reviews[$k]['place_name'],
                'country_name'          => $this->faker->country,
                'slug'                  => str_slug($title),
                'title'                 => $title,
                'short_description'     => $this->faker->realText(mt_rand(50, 250)),
                //'description'           => $this->faker->text(2000),
                'description'           => $reviews[$k]['description'],
                'place_location'        => DB::raw('POINT('.$lat.', '.$lng.')'),
                //'datetime_from'         => date('Y-m-d'),
                'datetime_from'         => $reviews[$k]['datetime_from'],
                'datetime_to'           => $this->faker->dateTimeBetween('1 years', '2 years'),
                //'updated_at'            => Carbon\Carbon::now(),
                'liked'                 => json_encode($liked),
                'recommended'           => json_encode($recommended),
                'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            ]);
        }

    }
}
