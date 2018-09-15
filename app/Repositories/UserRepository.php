<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;
use App\Models\Users\User;

class UserRepository
{
    /**
     * @param $userData
     * @return static
     */
    public function findByEmailOrCreateFacebookUser($attributes)
    {
        $fileData = json_decode(file_get_contents($attributes['url']));

        $user = User::query()->where([
            'email' => $attributes['email']
        ])->first();

        if (!$user) {
            $user = new User();
            $user->setPhotoUploads(true);
            $user->name = $attributes['name'];
            $user->email = $attributes['email'];
            $user->gender_sid = $attributes['gender'] = 'mail' ? 1 : 2;
            $user->profile_locale = App::checkAndGetLocale($attributes['locale'], true);
            $user->facebook_id = $attributes['id'];
            $user->uploadFileFromUrl($fileData->data->url, 'photo_path');

            $user->save();
        }

        return $user;
    }
}
