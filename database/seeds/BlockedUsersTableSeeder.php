<?php


use Illuminate\Database\Seeder;

class BlockedUsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<100; $i++) {
            DB::table('blocked_users')->insert([
                'user_id'     => mt_rand(1, 500),
                'blocked_user_id' => mt_rand(1, 500)
            ]);
        }
    }

}
