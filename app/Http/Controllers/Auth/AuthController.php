<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Social;
use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Contracts\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use DB;
use Exception;
use Log;
use Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * @var string
     */
    protected $loginView;

    /**
     * @var string
     */
    protected $registerView;

    /**
     * @var string
     */
    protected $redirectPath;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->loginView = config('auth.views.web.login_view');
        $this->registerView = config('auth.views.web.register_view');
        $this->redirectPath = config('auth.views.web.redirect_to');

        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * @param Request $request
     * @param Facebook $fb
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function facebookCallback(Request $request, Facebook $fb)
    {
        return $this->socialCallback($request, $fb);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $throttles = $this->isUsingThrottlesLoginsTrait();
        $lockedOut = $this->hasTooManyLoginAttempts($request);
        if ($throttles && ($lockedOut)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->getCredentials($request);

        if (\Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return redirect()->back()->with('email-login-failure', 'default');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegister()
    {
        $categories = construct_list_data(
            trans('models/categories'),
            []
        );

        return view($this->registerView, ['categories' => $categories]);
    }

    /**
     * @param Request $request
     * @param string $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function activate(Request $request, string $code)
    {

        try {
            $user = User::getPendingActivation($code);

            if (! $user) {
                throw new Exception('Invalid activation code.');
            }

            User::activate($user->id);

            // Notify user
            Mail::sendTo(
                $user->email,
                'email_confirmed',
                ['name' => $user->getName()]
            );

            Auth::loginUsingId($user->id);
            return $this->handleUserWasAuthenticated($request, false);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return view('app.auth.activation_failed', ['message' => $e->getMessage()]);
        }
    }

    /*********************** PROTECTED ***************************************************************/

    /**
     * @param Request $request
     * @param Social $social
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    protected function socialCallback(Request $request, Social $social)
    {

        try {
            $email = $social->getEmail();
            $id = $social->getId();

            $user = \DB::table('users AS u')
                ->select('id')
                ->join('users_oauths AS uo', 'u.id', '=', 'uo.user_id')
                ->where('uo.oauth_provider', ($social instanceof Facebook) ? 1 : 2);

            if ($email) {
                $user->where('u.email', $email);
            } elseif ($id) {
                $user->where('uo.oauth_id', '=', $id);
            } else {
                throw new \Exception('Failed to get social profile data.');
            }
            $user = $user->first();
            if ($user) {
                // If a registered social user with such id/provider exists then login it
                Auth::loginUsingId($user->id);
                return $this->handleUserWasAuthenticated($request, false);
            } else {
                // otherwise prompt to sign up
                return redirect('/register');
            }
        } catch (\Exception $e) {
            Session::flash('alert_type', 'danger');
            return redirect('/login')
                ->with('alert', $e->getMessage());
        }
    }
}
