<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Users\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * @package App\Http\Controllers\Admin
 */
class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showUsers(Request $request)
    {
        $users = User::paginate(config('app.rows_per_page'));

        if ($request->ajax()) {
            return $users;
        } else {
            return view(
                'admin.users.users',
                [
                    'users' => $users
                ]
            );
        }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddUser()
    {
        return view(
            'admin.users.add_edit_user',
            [
                'user' => new User,
                'action' => 'add',
                'categories' => trans('models/categories')
            ]
        );
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddUser(Request $request, User $user)
    {
        $user->setPhotoUploads(true);
        $user->create($request->input());
        return Redirect('/admin/users')->with(['alert' => 'User created.']);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return User|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditUser(Request $request, User $user)
    {
        if ($request->ajax()) {
            return $user;
        } else {
            $categories = construct_list_data(
                trans('models/categories'),
                $user->categories_bit
            );

            return view(
                'admin.users.add_edit_user',
                [
                    'user' => $user,
                    'action' => 'edit',
                    'categories' => $categories
                ]
            );
        }

    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditUser(Request $request, User $user)
    {
        $user->setPhotoUploads(true);
        $user->update($request->input());

        if (empty($request->input()['activated_at'])) {
            $user->activated_at = null;
        } elseif (! $user->activated_at) {
            $user->activated_at = date('Y-m-d H:i:s');
        }
        $user->save();

        return Redirect('/admin/users')
            ->with(['alert' => 'User '.$user->id.' updated.']);
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        return Redirect('/admin/users')
            ->with([
                'alert' => 'User '.$user->id.' deleted.',
                'alert_type' => 'danger'
            ]);
    }
}
