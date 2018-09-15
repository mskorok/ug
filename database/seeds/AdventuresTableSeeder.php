<?php


use Database\Importers\ActivitiesImporter;
use Database\Importers\UsersImporter;
use Illuminate\Database\Seeder;

class AdventuresTableSeeder extends Seeder
{
    protected $faker;
    protected $imgFaker;


    /**
     * AdventuresTableSeeder constructor.
     */
    public function __construct()
    {
        $this->faker =  Faker\Factory::create();
        $this->imgFaker = new \App\Helpers\ImageFaker();

    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importer = new ActivitiesImporter;
        $activities = $importer->parse();

        $activities_count = $importer->count();

        $users_count = (new UsersImporter)->count();

        for ($i = 0; $i < $activities_count; $i++) {

            //$title = $this->faker->catchPhrase;
            $title = $activities[$i]['title'];

            $going = [];
            for ($k = 0; $k < mt_rand(1, $users_count); $k++) {
                $going[] = $k + 1;
            }

            $following = [];
            for ($k = 0; $k < mt_rand(1, $users_count); $k++) {
                $following[] = $k + 1;
            }

            $liked = [];
            for ($k = 0; $k < mt_rand(1, $users_count); $k++) {
                $liked[] = $k + 1;
            }

            $lat = $this->faker->latitude;
            $lng = $this->faker->longitude;

            DB::table('adventures')->insert([
                //'is_private'            => mt_rand(0, 1),
                //'is_published'          => mt_rand(0, 1),
                'is_private'        => 0,
                'is_published'      => 1,
                //'user_id'               => /*$users[mt_rand(0, 9)],*/ mt_rand(1, 10),
                'user_id'            => $activities[$i]['user_id'],
                //'promo_image'           => $promo_image,
                'promo_image'            => $activities[$i]['promo_image'],
                'title'                 => $title,
                //'short_description'     => $this->faker->realText(mt_rand(50, 250)),
                'short_description'            => $activities[$i]['short_description'],
                //'description'           => $this->faker->text(2000),
                'description'            => $activities[$i]['description'],
                //'datetime_from'         => date('Y-m-d'),
                'datetime_from'            => $activities[$i]['datetime_from'],
                //'datetime_to'           => $this->faker->dateTimeBetween('now', '1 years'),
                'datetime_to'            => $activities[$i]['datetime_to'],
                'place_id'              => $this->faker->text(120),
                'like_count'            => sizeof($liked) - 1,
                'place_location'        => DB::raw('POINT('.$lat.', '.$lng.')'),
                //'place_name'            => $this->faker->city,
                'place_name'            => $activities[$i]['place_name'],
                'country_name'          => $this->faker->country,
                'slug'                  => str_slug($title),
                //'category_sid'       => mt_rand(0, 7),
                'category_sid'            => $activities[$i]['category_sid'],
                //'updated_at'            => \Carbon\Carbon::now(),
                'going'                 => json_encode($going),
                'following'             => json_encode($following),
                'liked'                 => json_encode($liked),
                'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            ]);
        }

    }
}
