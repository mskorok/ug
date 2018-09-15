<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Users\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class PublicProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show profile page.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function showProfile(User $user)
    {
        return view('app.profile.public.about', ['user' => $user]);
    }

    public function showActivities(User $user, Request $request)
    {
        $activities = $user->getProfileAdventuresQ()->paginate(12);
        $page = (int)Input::get('page', 1);
        $showMore = ($activities->lastPage() > $page) ? true : false;

        if ($request->ajax()) {

            $returnHTML = view(
                'app._partials.adventures_row',
                [
                    'adventures' => $activities,
                ]
            )->render();

            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'lastPage' => $activities->lastPage(),
                'showMore' => $showMore
            ]);
        } else {
            return view(
                'app.profile.public.activities',
                [
                    'activities' => $activities,
                    'showMore' => $showMore,
                    'user' => $user
                ]
            );
        }
    }

    public function showReviews(User $user, Request $request) {

        $reviews = $user
                    ->reviews()
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6);

        $page = (int)Input::get('page', 1);
        $showMore = ($reviews->lastPage() > $page) ? true : false;

        if ($request->ajax()) {

            $returnHTML = view(
                'app._partials.reviews_row',
                [
                    'reviews' => $reviews,
                ]
            )->render();

            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'lastPage' => $reviews->lastPage(),
                'showMore' => $showMore
            ]);
        } else {
            return view(
                'app.profile.public.reviews',
                [
                    'reviews' => $reviews,
                    'showMore' => $showMore,
                    'user' => $user
                ]
            );
        }
    }

    public function showFriends(User $user, Request $request) {

        $friends = $user->getFriendsQ()->paginate(12);

        $page = (int)Input::get('page', 1);
        $showMore = ($friends->lastPage() > $page) ? true : false;

        if ($request->ajax()) {

            $returnHTML = view(
                'app._partials.friends_row',
                [
                    'friends' => $friends,
                ]
            )->render();

            return response()->json([
                'success' => true,
                'html' => $returnHTML,
                'lastPage' => $friends->lastPage(),
                'showMore' => $showMore
            ]);
        } else {
            return view(
                'app.profile.public.friends',
                [
                    'friends' => $friends,
                    'showMore' => $showMore,
                    'user' => $user
                ]
            );
        }
    }
}
