<?php

/*

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `users_test`;
CREATE TABLE `users_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `users_test_json`;
CREATE TABLE `users_test_json` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `auth_profiles` JSON,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `users_test_profiles`;
CREATE TABLE `users_test_profiles` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_uid` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oauth_provider` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`user_id`, `oauth_uid`),
  UNIQUE KEY `users_test_profiles_uid_unique` (`oauth_uid`),
  KEY `users_test_profiles_provider_index` (`oauth_provider`),
  CONSTRAINT `users_test_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users_test` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;




CREATE TABLE `users_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_show_age` tinyint(1) NOT NULL DEFAULT '1',
  `gender_sid` tinyint(1) NOT NULL,
  `categories_bit` int(10) unsigned NOT NULL,
  `facebook_id` bigint(20) unsigned NOT NULL,
  `profile_locale` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adventurer_title` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_path` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `work` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login_ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` datetime NOT NULL,
  `birth_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_test_email_unique` (`email`),
  KEY `users_test_country_id_index` (`country_id`),
  KEY `users_test_city_id_index` (`city_id`),
  FULLTEXT KEY `t_first_last_name_email_fulltext` (`email`,`last_name`,`first_name`),
  CONSTRAINT `users_test_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `users_test_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `users_test_json` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_show_age` tinyint(1) NOT NULL DEFAULT '1',
  `gender_sid` tinyint(1) NOT NULL,
  `categories_bit` int(10) unsigned NOT NULL,
  `facebook_id` bigint(20) unsigned NOT NULL,
  `profile_locale` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adventurer_title` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_path` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `work` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login_ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_profiles` json DEFAULT NULL,
  `last_login_at` datetime NOT NULL,
  `birth_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_test_json_email_unique` (`email`),
  KEY `users_test_json_country_id_index` (`country_id`),
  KEY `users_test_json_city_id_index` (`city_id`),
  FULLTEXT KEY `tj_first_last_name_email_fulltext` (`email`,`last_name`,`first_name`),
  CONSTRAINT `users_test_json_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `users_test_json_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `users_test_profiles` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_uid` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oauth_provider` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`oauth_uid`),
  UNIQUE KEY `users_test_profiles_uid_unique` (`oauth_uid`),
  KEY `users_test_profiles_provider_index` (`oauth_provider`),
  CONSTRAINT `users_test_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users_test` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        /*$imgFaker = new \App\Helpers\ImageFaker();

        $langs = ['en', 'de'];

        //$countries = \App\Models\Geo\Country::query()->get(['id'])->toArray();

        $cities = DB::select(DB::raw('SELECT id, country_id FROM cities LIMIT 0,1001'));

        $oauth_providers = ['facebook', 'google', 'twitter'];

        for ($k=0; $k<1900; $k++) {
            //$country_id = $faker->randomElement($countries)['id'];

            //$cities = \App\Models\Geo\City::query()->
            //            where('country_id', $country_id)
            //            ->get(['id'])->toArray();

            //$city_id = $faker->randomElement($cities)['id'];
            //if (! $city_id) { continue; }

            $city_id = mt_rand(1, 1000);
            $country_id = $cities[$city_id]->country_id;

            $profile_show_age = mt_rand(0, 1);
            $gender_sid = mt_rand(1, 2);
            $categories_bit = mt_rand(0, 255);

            $profile_locale = $langs[mt_rand(0, 1)];

            $first_name = $faker->firstName;
            $last_name = $faker->lastName;
            $email = $faker->email;
            $title = $faker->title;
            $photo_path = $imgFaker->userPhoto();

            $about = $faker->text;
            $work = $faker->sentence;

            $birth_date = $faker->date();

            $providers = mt_rand(0, 2);

            $auth_profiles = [];

            for ($j = 0; $j < $providers; $j++) {
                $auth_profiles[$oauth_providers[$j]] = [
                    'oauth_uid' => str_random(mt_rand(4, 32))
                ];
            }

            DB::table('users_test')->insert([
                'profile_show_age' => $profile_show_age,
                'gender_sid' => $gender_sid,
                'categories_bit' => $categories_bit,

                'profile_locale' => $profile_locale,

                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => bcrypt('12345678'),
                'adventurer_title' => $title,
                'photo_path' => $photo_path,
                'about' => $about,
                'work' => $work,
                'birth_date' => $birth_date,
                'country_id' => $country_id,
                'city_id' => $city_id
            ]);

            foreach ($auth_profiles as $auth_profile_name => $auth_profile) {
                DB::table('users_test_profiles')->insert([
                    'user_id' => $k + 100,
                    'oauth_uid' => $auth_profile['oauth_uid'],
                    'oauth_provider' => $auth_profile_name
                ]);
            }

            DB::table('users_test_json')->insert([
                'profile_show_age' => $profile_show_age,
                'gender_sid' => $gender_sid,
                'categories_bit' => $categories_bit,

                'profile_locale' => $profile_locale,

                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => bcrypt('12345678'),
                'adventurer_title' => $title,
                'photo_path' => $photo_path,
                'about' => $about,
                'work' => $work,

                'auth_profiles' => json_encode($auth_profiles),

                'birth_date' => $birth_date,
                'country_id' => $country_id,
                'city_id' => $city_id
            ]);
        }*/

        $oauth_providers = ['facebook', 'google', 'twitter', 'microsoft', 'github', 'draugiem', 'qq'];

        $repeat_count = 100;
        $q_cnt = 1000;

        for ($r = 0; $r < $repeat_count; $r++) {

            $q1 = [];
            $q2 = [];
            $q3 = [];

            for ($k = 1; $k <= $q_cnt; $k++) {

                //echo $k + $r * $q_cnt . PHP_EOL;

                $size = mt_rand(0, sizeof($oauth_providers));

                $first_name = $faker->firstName;

                $last_name = $faker->lastName;

                if ($size > 1) {
                    $providers_indexes = array_rand($oauth_providers, $size);
                } elseif ($size === 1) {
                    $providers_indexes = [array_rand($oauth_providers)];
                } else {
                    $providers_indexes = [];
                }

                $json = [];

                foreach ($providers_indexes as $provider_index) {

                    $oauth_id = str_random(32, 64);
                    $access_token = str_random(64, 128);
                    $is_active = mt_rand(0, 1);

                    $json[$oauth_providers[$provider_index]] = [
                        'oauth_uid' => $oauth_id,
                        'access_token' => $access_token,
                        'is_active' => $is_active
                    ];

                    $q2[] = [
                        'user_id' => $k + $r * $q_cnt,
                        'oauth_uid' => $oauth_id,
                        'oauth_provider' => $oauth_providers[$provider_index],
                        'access_token' => $access_token,
                        'is_active' => $is_active
                    ];
                }

                $q1[] = [
                    'id' => $k + $r * $q_cnt,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                ];

                $q3[] = [
                    'id' => $k + $r * $q_cnt,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'auth_profiles' => json_encode($json)
                ];
            }

            DB::table('users_test')->insert($q1);
            DB::table('users_test_profiles')->insert($q2);
            DB::table('users_test_json')->insert($q3);
        }

    }
}
