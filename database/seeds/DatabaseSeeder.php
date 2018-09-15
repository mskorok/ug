<?php

use Database\Importers\ActivitiesImporter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '-1');

        $this->call(AdminsTableSeeder::class);

        $this->call(InterestsTableSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(UsersInterestsTableSeeder::class);
        $this->call(UsersLanguagesTableSeeder::class);

        $this->call(AdventuresTableSeeder::class);
        $this->call(ActivitiesCommentsTableSeeder::class);
        $this->call(ActivitiesInterestsTableSeeder::class);

        $this->call(ReviewsTableSeeder::class);
        $this->call(ReviewsCommentsTableSeeder::class);
        $this->call(ReviewsInterestsTableSeeder::class);
    }
}
