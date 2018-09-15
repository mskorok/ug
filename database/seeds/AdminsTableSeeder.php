<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Test admin',
            'email' => 'test@admin.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
