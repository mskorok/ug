<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Users\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditProfile()
    {
        $user = \Auth::user();

        return view('app.profile.edit.main', ['user' => $user]);
    }
}
