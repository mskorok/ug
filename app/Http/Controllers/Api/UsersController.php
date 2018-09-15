<?php

namespace App\Http\Controllers\Api;

use App\Models\Traits\Interestable;
use App\Models\Users\BlockedUsers;
use App\Models\Users\User;
use App\Services\FacebookService;
use Facebook\Facebook;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * @package App\Http\Controllers\Api
 */
class UsersController extends RestController
{
    use Interestable;
    /**
     * @param Request $request
     * @param $email
     * @return mixed
     */
    public function checkEmail(Request $request, $email)
    {
        $validator = app('validator')
            ->make(
                ['email' => $email],
                ['email' => 'bail|required|email|unique:users']
            );

        if ($validator->fails()) {
            return $this->fail($validator->errors()->all());
        } else {
            return $this->success('Validation passed.');
        }
    }

    /**
     * @param $interest
     * @param User $user
     * @return string
     */
    public function addInterest($interest, User $user)
    {
        return $this->addInterestToModel($user, $interest);
    }


    /**
     * @param $interest
     * @param User $user
     * @return string
     */
    public function removeInterest($interest, User $user)
    {
        return $this->removeInterestFromModel($user, $interest);
    }


    /**
     * @param int $user
     * @param null $page
     * @return array|\Illuminate\Support\Collection|mixed|static[]
     */
    public function interests($user, $page = null)
    {
        $user = User::find((int) $user);
        return $this->getInterests($user, $page);
    }

    /**
     * @return array
     */
    public function usersFirstLastNameString()
    {
        $users = User::all();
        $res = [];
        foreach ($users as $user) {
            $res[$user->id] = $user->getName().' ( '.$user->email.' )';
        }
        return $res;
    }

    /**
     * @param $slug
     * @return int
     */
    public function userById($slug)
    {
        if (is_numeric($slug)) {
            $user = User::find((int) $slug);
            if ($user instanceof User) {
                return $user;
            }
        }
        $users = User::all();
        $res = [];
        foreach ($users as $user) {
            $res[$user->getName().' ( '.$user->email.' )'] = $user->id;
        }
        $id = $res[$slug] ?? 0;
        $user = User::find($id);
        if (!$user) {
            return json_encode(['error']);
        }
        return $user;
    }

    public function unblockUser(User $user, User $blockedUSer)
    {
        dd($blockedUSer);

//        if (\Request::ajax()) {
//            if (\Auth::check()) {
//                $user_id = (\Auth::guard('admin')->check()) ? $user->id : \Auth::id();
//                \DB::table('blocked_users')->where([
//                    'user_id' => $user_id,
//                    'blocked_user_id' => $blockedUSer->id
//                ])->delete();
//                return json_encode(['result' => true]);
//            } else {
//                return json_encode(['result' => false]);
//            }
//        } else {
//            return redirect($this->getRedirectUrl());
//        }
    }


    /**
     * @param User $user
     * @param User $blockedUSer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function blockUser(User $user, User $blockedUSer)
    {
        if (\Request::ajax()) {
            if (\Auth::check()) {
                $user_id = (\Auth::guard('admin')->check()) ? $user->id : \Auth::id();
                if ($user_id == $blockedUSer->id) {
                    return json_encode(['result' => false]);
                }
                $blocked = BlockedUsers::where('user_id', '=', $user_id)
                    ->where('blocked_user_id', '=', $blockedUSer->id)->get();
                if ($blocked->count() == 0) {
                    try {
                        \DB::table('blocked_users')->insert([
                            'user_id' => $user_id,
                            'blocked_user_id' => $blockedUSer->id
                        ]);
                    } catch (\mysqli_sql_exception $e) {
                        return json_encode(['result' => false, 'message'  => $e->getMessage()]);
                    }
                } else {
                    return json_encode(['result' => false, 'message'  => 'User already blocked']);
                }

                return json_encode(['result' => true]);
            } else {
                return json_encode(['result' => false]);
            }
        } else {
            return redirect($this->getRedirectUrl());
        }
    }
}
