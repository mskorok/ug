<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * Class AdminAuthController
 * @package App\Http\Controllers\Admin\Auth
 */
class AdminAuthController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->loginView = config('auth.views.admin.login_view');
        $this->registerView = config('auth.views.admin.register_view');
        $this->redirectTo = config('auth.views.admin.redirect_to');
        $this->redirectAfterLogout = config('auth.views.admin.redirect_after_logout');
        $this->guard = 'admin';

        //$this->middleware('guest', ['except' => 'logout']);
    }
}
