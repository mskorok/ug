<?php

namespace App\Helpers;

class ImageFaker
{
    protected $users_photos_path = '/img/test_promo/users';
    protected $activities_photos_path = '/img/test_promo/activities';
    protected $reviews_photos_path = '/img/test_promo/reviews';

    private $user_files = [];
    private $activity_files = [];
    private $review_files = [];

    public function __construct()
    {
        chdir(public_path($this->users_photos_path));
        $this->user_files = glob('*');
        $this->user_files[] = '';

        chdir(public_path($this->activities_photos_path));
        $this->activity_files = glob('*');
        $this->activity_files[] = '';
        chdir(base_path());

        chdir(public_path($this->reviews_photos_path));
        $this->review_files = glob('*');
        $this->review_files[] = '';
        chdir(base_path());
    }

    public function user($no_image = true)
    {
        $max = sizeof($this->user_files) - 1;
        if (!$no_image) {
            $max = $max - 1;
        }
        $k = mt_rand(0, $max);
        if ($this->user_files[$k] === '') {
            return config('_project.no_avatar_image_path');
        }
        return $this->users_photos_path . '/'. $this->user_files[$k];
    }

    public function directUser($file_name)
    {
        foreach($this->user_files as $user_file) {
            if (strpos($user_file, $file_name) !== false) {
                return $this->users_photos_path . '/'. $user_file;
            }
        }
        return false;
    }

    public function activity($no_image = false)
    {
        $max = sizeof($this->activity_files) - 1;
        if (!$no_image) {
            $max = $max - 1;
        }
        $k = mt_rand(0, $max);
        if ($this->activity_files[$k] === '') {
            return '';
        }
        return $this->activities_photos_path . '/'. $this->activity_files[$k];
    }

    public function directActivity($file_name)
    {
        foreach($this->activity_files as $activity_file) {
            if (strpos($activity_file, $file_name) !== false) {
                return $this->activities_photos_path . '/'. $activity_file;
            }
        }
        return false;
    }

    public function review($no_image = false)
    {
        $max = sizeof($this->review_files) - 1;
        if (!$no_image) {
            $max = $max - 1;
        }
        $k = mt_rand(0, $max);
        if ($this->review_files[$k] === '') {
            return '';
        }
        return $this->reviews_photos_path . '/'. $this->review_files[$k];
    }

    public function directReview($file_name)
    {
        foreach($this->review_files as $review_file) {
            if (strpos($review_file, $file_name) !== false) {
                return $this->reviews_photos_path . '/'. $review_file;
            }
        }
        return false;
    }

}
