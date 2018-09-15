<?php

use App\Models\Reviews\ReviewComment;
use Database\Importers\ReviewsImporter;
use Database\Importers\UsersImporter;
use Illuminate\Database\Seeder;

class ReviewsCommentsTableSeeder extends Seeder
{

    protected $faker;
    protected $imgFaker;


    /**
     * PostsTableSeeder constructor.
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
        $reviews_count = (new ReviewsImporter)->count();
        $users_count = (new UsersImporter)->count();

        for ($i = 1; $i < $reviews_count; $i++) {
            $start = ($i - 1) * 10;

            for ($j = ($start + 1); $j < ($start + 11); $j++) {
                $parentId = ($j < ($start + 4)) ? null : mt_rand(($start +1 ), ($start + 3));


                $users = mt_rand(1, 10);
                $userId = mt_rand(1, $users_count);
                $arr = [];
                while (count($arr) < $users) {
                    $user = mt_rand(1, 500);
                    if (!in_array($user, $arr)  && $user != $userId) {
                        $arr[] = $user;
                    }
                }

                DB::table('reviews_comments')->insert([
                    'review_id'      => $i,
                    'user_id'        => $userId,
                    'parent_id'      => $parentId,
                    'text'           => $this->faker->text(200),
                    'created_at'     => \Carbon\Carbon::now(),
                    //'updated_at'     => \Carbon\Carbon::now(),
                    'like_count'     => count($arr),
                    'reply_count'    => mt_rand(1, 50),
                    'liked'          => json_encode($arr)
                ]);
            }

            DB::table('reviews')->whereId($i)->update(['comments_count' => 10]);
        }

        $comments = ReviewComment::all();
        /** @var ReviewComment $comment */
        foreach ($comments as $comment) {
            $comment->reply_count = count($comment->responses);
            $comment->save();
        }
    }
}
