<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 16:25
 */

namespace User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class UserRegistrationController
 *
 * @package User
 */
class UserRegistrationController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\User\UserRepositoryInterface
     */
    private $user;

    /**
     * @param UserRepositoryInterface $user
     */
    function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return View::make('pages.register');
    }

    /**
     * @return array
     */
    public function registration()
    {
        $form = $this->user->getRegistrationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return $response = [
                'Status'     => 'Validation',
                'validation' => [
                    'email'      => $message->first('email'),
                    'password'   => $message->first('password'),
                    'name'       => $message->first('name'),
                    'organisasi' => $message->first('organisasi')
                ],
            ];
        }

        $data = $form->getInputData();
        $result = $this->user->create($data);

        return [
            'Status' => 'Info',
            'msg'    => 'Registrasi anda berhasil, sebuah email konfirmasi telah dikirim ke alamat : <b>'. $result->email . '</b> ikuti petunjuk yang ada didalamnya.',
        ];
    }

}