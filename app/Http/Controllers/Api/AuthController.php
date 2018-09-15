<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Geo;
use App\Enumerations\SocialProviders;
use App\Models\Users\User;
use App\Models\Validators\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Log;
use Exception;
use Auth;
use DB;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends RestController
{


    /**
     * @var Geo
     */
    protected $geoProvider;


    /**
     * ActivitiesController constructor.
     * @param Request $request
     * @param Geo $geoProvider
     */
    public function __construct(Request $request, Geo $geoProvider)
    {
        parent::__construct($request);
        $this->geoProvider = $geoProvider;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function signUp(Request $request)
    {
        try {
            $inputs = $request->all();

            if ($this->userExist($inputs)) {
                return $this->registered('User already registered');
            }


            $b_email_set = isset($inputs['email']) && $inputs['email'] !== '';
            $b_social_id_set = isset($inputs['social_id']) && $inputs['social_id'] !== '';

            if (!$b_email_set && !$b_social_id_set) {
                throw new Exception('social_id or email field must be filled');
            }

            $inputs = $this->checkGeoData($inputs);
            if ($inputs instanceof \Throwable) {
                return $this->throwable($inputs);
            }
            $validator = UserValidator::make($inputs);
            if ($validator->fails()) {
                return $this->fail($validator->errors()->all());
            } else {
                $user = User::createWithRelatedEntities($inputs);

                if (!($user instanceof User)) {
                    throw new Exception('Can`t create User');
                }

                if ($b_email_set) {
                    $this->sendActivationEmail($user);
                }

                Auth::loginUsingId($user->id);

                if ($b_email_set) {
                    flash('app/auth.flash_finish_email', ['email' => $inputs['email']]);
                } else {
                    flash('app/auth.flash_finish_no_email');
                }

                return $this->success('User registered successfully.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->error($e);
        }
    }

    /**
     * @param $user
     * @return bool|mixed
     */
    public function sendActivationEmail($user)
    {
        try {
            Mail::sendTo(
                $user->email,
                'registration_complete',
                [
                    'name' => $user->getName(),
                    'activation_link' => url('/confirm-email/' . $user->activation_code)
                ]
            );
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->error($e);
        }

    }

    /**
     * @param $user
     */
    public function sendPasswordChangedEmail($user)
    {
        Mail::sendTo(
            $user->email,
            'password_changed',
            ['name' => $user->getName()]
        );
    }

    /**
     * Tries to login with the specified social account.
     * In case of failure searches for an account with the same email. In case if found, links the specified social
     * account to existing ugluck account and logs user in, otherwise login fails.
     *
     * @param Request $request
     * @return mixed
     */
    public function socialLogin(Request $request)
    {

        try {
            $input = $request->all();

            $validator = app('validator')
                ->make(
                    $input,
                    [
                        'provider' => 'required|in:google,facebook',
                        'token' => 'sometimes|required|string'
                    ]
                );

            if ($validator->fails()) {
                return $this->fail($validator->errors()->first());
            } else {
                $socialService = app($input['provider']);
                $provider = SocialProviders::getId($input['provider']);
                $socialUser = $socialService->getProfileData($input['token'] ?? null);

                $userRecords = DB::table('users AS u')
                    ->leftJoin('users_oauths AS uo', 'u.id', '=', 'uo.user_id')
                    ->select(['u.id AS id', 'uo.oauth_id', 'uo.oauth_provider'])
                    ->where('u.email', $socialUser['email'])
                    ->get();

                if (!empty($userRecords)) {
                    // Is the account linked to specified social provider?
                    $user = array_first($userRecords, function ($key, $rec) use ($input, $socialUser) {
                        return $rec->oauth_provider == $input['provider'] && $rec->oauth_id == $socialUser['id'];
                    });

                    if (! $user) {
                        // If not linked then link and login
                        $user = $userRecords[0];
                        User::saveSocialId($input['provider'], $socialUser['id'], $user->id);
                    }

                    // If the account and link to provider exist, then just login
                    Auth::loginUsingId($user->id);

                    return $this->success('Logged in with a ' . ucfirst($input['provider']) . ' account.');
                } else {
                    $userRecord = DB::table('users AS u')
                        ->leftJoin('users_oauths AS uo', 'u.id', '=', 'uo.user_id')
                        ->select(['u.id AS id', 'uo.oauth_id', 'uo.oauth_provider'])
                        ->where('uo.oauth_id', '=', $socialUser['id'])
                        ->where('uo.oauth_provider', '=', $provider)
                        ->first();
                    if (!empty($userRecord)) {
                        Auth::loginUsingId($userRecord->id);

                        \Session::flash('alert_type', 'success');
                        \Session::flash('alert', \Lang::get('auth.add_email'));
                        \Session::flash('unescape', true);


                        return $this->success('Logged in with a ' . ucfirst($input['provider']) . ' account.');
                    }
                }

                throw new Exception('No user registered for this ' . ucfirst($input['provider']) . ' account.');
            }
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function changePassword(Request $request)
    {
        try {
            $input = $request->all();

            $rules = [
                'password' => 'required|min:8|max:255|confirmed',
                'password_confirmation' => 'required|min:8|max:255'
            ];

            $user = Auth::user();

            // Password is required only for users with no social account attached
            if (empty($user->oauths()->first())) {
                $rules['old_password'] = 'required|min:8|max:255';
            }

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return $this->fail($validator->errors()->first());
            } else {
                // Check old password
                if (isset($input['old_password']) && ! Auth::attempt(
                    ['email' => $user->email,
                    'password' => $input['old_password']]
                )) {
                    return $this->fail('Invalid current password');
                }

                $user->password = $input['password'];
                $user->save();

                $this->sendPasswordChangedEmail($user);

                return $this->success('Password changed');
            }
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deactivateAccount(Request $request)
    {
        try {
            $input = $request->all();
            $user = Auth::user();

            $rules = empty($user->password) ? [] : ['password' => 'required|min:8|max:255'];

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return $this->fail($validator->errors()->first());
            } else {
                // Check old password
                if (! empty($user->password) && ! Auth::attempt(
                    ['email' => $user->email,
                     'password' => $input['password']]
                )) {
                    return $this->fail('Invalid password');
                }

                $user->is_active = false;
                $user->save();

                return $this->success('Account deactivated');
            }
        } catch (Exception $e) {
            return $this->error($e);
        }
    }


    /**
     * @param array $input
     * @return array|null
     */
    protected function checkGeoData(array $input)
    {
        try {
           // Validate place
            $geo = $this->geoProvider->getPlace(
                $input['hometown_name'] ?? null,
                $input['place_id'] ?? null,
                $input['location_lat'] ?? null,
                $input['location_lng'] ?? null
            );

            $input['hometown_lat'] = $input['location_lat'];
            $input['hometown_lng'] = $input['location_lng'];
            $input['hometown_location'] = ($geo) ? $geo['place_location'] : 'POINT(0 , 0)';
            $input['hometown_id'] = ($geo) ? $geo['place_id'] : '';
            $input['geo_service'] = ($geo) ? $geo['geo_service'] : 'google';


            return $input;
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
            return $e;
        }

    }

    /**
     * @param array $input
     * @return null|User
     */
    protected function userExist(array $input)
    {
        $user = null;
        if (is_array($input) && array_key_exists('email', $input)) {
            $user = User::where('email', '=', $input['email'])->first();
            if (!($user instanceof User)) {
                $user = null;
            }
        }
        return $user;
    }
}
