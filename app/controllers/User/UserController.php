<?php
namespace User;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class UserController
 * @package User
 */
class UserController extends \BaseController
{
    protected $event;

    public function __construct(UserRepositoryInterface $auth, Dispatcher $event)
    {
        $this->auth = $auth;
        $this->event = $event;
    }


    /**
     * @return mixed
     */
    public function Index()
    {
        return \View::make('pages.login');
    }

    public function postLogin()
    {
        // todo : mencari alternatif yang lain untuk credential
        // yang ini masih belum fix, username masih belum bisa
        // jika tidak ditambah input only email akan error
        $credentials = \Input::only(['username', 'password', 'email']);
        $remember = \Input::get('remember', false);

        if (str_contains($credentials['username'], '@')) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        if (\Auth::attempt($credentials, $remember)) {
            // redirect to dashboard
            return $this->redirectIntended('dashboard');

        }

        return $this->redirectBack(['login_errors' => true]);
    }

    /**
     * @return mixed
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::route("auth.login");
    }
}