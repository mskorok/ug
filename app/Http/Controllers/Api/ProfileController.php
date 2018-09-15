<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Geo;
use App\Http\Requests;
use App\Models\Users\BlockedUsers;
use App\Models\Users\User;
use App\Models\Validators\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Api
 */
class ProfileController extends RestController
{

    /**
     * @param Request $request
     * @param Geo $geoProvider
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function postEdit(Request $request, Geo $geoProvider)
    {
        try {
            $input = $request->all();
            /** @var User $user */
            $user = \Auth::user();
            $input['id'] = $user->id;

            // Validate place
            $geo = $geoProvider->getPlace(
                $input['hometown_name'],
                $input['hometown_id'],
                $input['hometown_lat'],
                $input['hometown_lng']
            );

            if (! empty($geo)) {
                $input['geo_service'] = $geo['geo_service'];
                $input['country_code'] = $geo['country_code'];
                $input['country_name'] = $geo['country_name'];
                $input['hometown_location'] = $geo['place_location'];

                $validator = UserValidator::make($input);

                if ($validator->fails()) {
                    \Log::error('User validation error (id=' . $user->id . '): '.$validator->messages()->first());
                } else {
                    if (! empty($input['disconnect_fb']) || ! empty($input['disconnect_google'])) {
                        if (empty($user->password)) {
                            throw new \Exception('Cannot disconnect until a password set.');
                        }

                        if (empty($user->email)) {
                            throw new \Exception('Cannot disconnect until an email set.');
                        }
                    }

                    if (! empty($input['disconnect_fb'])) {
                        $user->unlinkFacebookAccount();
                        //$result = app('facebook')->revokePermissions();
                    }

                    if (! empty($input['disconnect_google'])) {
                        $user->unlinkGoogleAccount();
                    }

                    $user = User::updateWithRelatedEntities($input);

                    return $this->success('User successfully updated');
                }
            } else {
                throw new \Exception(
                    'Edit profile -> Inconsistent hometown data: [' .
                    'Name: ' . $input['hometown_name'] . ', '.
                    'ID: ' . $input['hometown_id'] . ', ' .
                    'Lat: ' . $input['hometown_lat'] . ', ' .
                    'Lng: ' . $input['hometown_lng'] . ']'
                );
            }
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postNotifications(Request $request)
    {
        try {
            $input = $request->all();
            $user = \Auth::user();

            $user->email_notifications_bit = array_keys($input['email_notifications_bit'] ?? []);
            $user->alert_notifications_bit = array_keys($input['alert_notifications_bit'] ?? []);
            $user->save();

            return $this->success('Notifications saved.');
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }

    /**
     * @return mixed
     */
    public function getIsPasswordEmpty()
    {
        $result = empty(Auth::user()->password);

        return $this->success($result);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unblockUser(Request $request)
    {
        try {
            $input = $request->all();
            $user = \Auth::user();

            $rules = ['id' => 'required|integer|min:1'];

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return $this->fail($validator->errors()->first());
            } else {
                $affected = \DB::table('blocked_users')
                    ->where('user_id', $user->id)
                    ->where('blocked_user_id', $input['id'])
                    ->delete();

                return $this->success($affected);
            }
        } catch (\Exception $e) {
            return parent::error($e);
        }
    }
}
