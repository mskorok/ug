<?php

use Illuminate\Database\Seeder;

class InterestsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importer = new \Database\Importers\InterestsImporter();
        $interests = $importer->parse();

        DB::table('interests')->insert($interests);

        /*$interests = file_get_contents(dump_path('interests.csv'));
        $interests = str_replace("\n", '', $interests);
        $interests = str_replace("\r", ',', $interests);
        $data = array_values(
            array_filter(explode(',', $interests))
        );

        foreach ($data as $item) {
            DB::table('interests')->insert([
                'name' => $item,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ]);
        }


        $userIds = DB::table('users')->get(['id']);
        $insert = [];
        foreach ($userIds as $userId) {
            $interests = [];
            do {
                $i = mt_rand(1, 78);
                $interest = $data[$i];
                if (!in_array($interest, $interests)) {
                    $interests[] = $interest;
                }
            } while (count($interests) < 10);

            foreach ($interests as $item) {
                $interestId = DB::table('interests')->where('name', $item)->pluck('id');

                $insert[] = [
                    'interest_id'  => $interestId[0],
                    'user_id'      => $userId->id,
                    'created_at'   => \Carbon\Carbon::now(),
                    'updated_at'   => \Carbon\Carbon::now()
                ];
            }
        }
        if (count($insert)> 0) {
            DB::table('interest_user')->insert($insert);
        }

        $adventureIds = DB::table('adventures')->get(['id']);
        $insert = [];
        foreach ($adventureIds as $adventureId) {
            $interests = [];
            do {
                $i = mt_rand(1, 78);
                $interest = $data[$i];
                if (!in_array($interest, $interests)) {
                    $interests[] = $interest;
                }
            } while (count($interests) < 10);

            foreach ($interests as $item) {
                $interestId = DB::table('interests')->where('name', $item)->pluck('id');

                $insert[] = [
                    'interest_id'  => $interestId[0],
                    'adventure_id' => $adventureId->id,
                    'created_at'   => \Carbon\Carbon::now(),
                    'updated_at'   => \Carbon\Carbon::now()
                ] ;

            }
        }

        if (count($insert)> 0) {
            DB::table('adventure_interest')->insert($insert);
        }



        $reviewIds = DB::table('reviews')->get(['id']);

        $insert = [];
        foreach ($reviewIds as $reviewId) {
            $interests = [];
            do {
                $i = mt_rand(1, 78);
                $interest = $data[$i];
                if (!in_array($interest, $interests)) {
                    $interests[] = $interest;
                }
            } while (count($interests) < 10);

            foreach ($interests as $item) {
                $interestId = DB::table('interests')->where('name', $item)->pluck('id');

                $insert[] = [
                    'interest_id'  => $interestId[0],
                    'review_id' => $reviewId->id,
                    'created_at'   => \Carbon\Carbon::now(),
                    'updated_at'   => \Carbon\Carbon::now()
                ] ;

            }
        }

        if (count($insert)> 0) {
            DB::table('interest_review')->insert($insert);
        }*/
    }
}
