<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 7/21/2014
 * Time: 11:27
 */

namespace User;

use Simdes\Repositories\User\AuthRepositoryInterface;

class AuthController extends \BaseController
{

    public function __construct(AuthRepositoryInterface $auth)
    {
        $this->auth = $auth;
    }

    public function index()
    {
        if ($this->auth->cek()) {
            $this->redirectURLTo('dashboard');
        }

        $this->redirectURLTo('login');
    }

    public function postLogin()
    {
        $credentials = \Input::only(['username', 'password']);
        $remember = \Input::get('remember', false);

        // deteksi login dengan email atau username jika
        // terdapat karakter @ maka email akan berlaku
        // jika tidak ada maka username akan berlaku
        if (str_contains($credentials['username'], '@')) {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        // cek username dan password benar
        if ($this->auth->attempt($credentials, $remember)) {
            return $this->redirectIntended(route('dashboard'));
        }

        return $this->redirectBack(['login_errors' => true]);

//        if (Auth::attempt($credentials, $remember)) {
//            return $this->redirectIntended(route('dashboard'));
//        }
    }

} 