<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

/**
 * Class PeopleController
 * @package App\Http\Controllers
 */
class PeopleController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Exception
     * @throws \Throwable
     */
    public function showPeople(Request $request)
    {
        $categories = construct_list_data(
            trans('models/categories'),
            array_keys(Input::get('categories', [])),
            'checked'
        );

        $userId = Auth::user()->id;

        switch (Input::get('tab')) {
            case 'people_new':
                $q = User::getPeopleNewQ($userId, $categories);
                break;
            case 'people_popular':
                $q = User::getPeoplePopularQ($userId, $categories);
                break;
            case 'people_friends':
                $q = User::getPeopleFriendsQ($userId, $categories);
                break;
            default:
                $q = User::getPeopleNewQ($userId, $categories);
        }

        $users = $q->paginate(19);

        $page = (int)$request->get('page', 1);
        $showMore = ($users->lastPage() > $page) ? true : false;

        if ($request->ajax()) {
            $returnHTML = view(
                'app.people._partials.people_row',
                [
                    'users' => $users,
                ]
            )->render();
            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'lastPage' => $users->lastPage(),
                'showMore' => $showMore,
                'categories' => $categories
            ]);
        } else {
            return view(
                'app.people.main',
                [
                    'categories' => $categories,
                    'users' => $users,
                    'showMore' => $showMore
                ]
            );
        }
    }
}
