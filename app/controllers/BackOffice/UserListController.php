<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 8/8/2014
 * Time: 09:44
 */

namespace BackOffice;


use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class UserListController
 * @package BackOffice
 */
class UserListController extends \BaseController
{

    /**
     * @var UserRepositoryInterface
     */
    private $user;

    /**
     * @param UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     *
     */
    public function index()
    {
        $this->view('backoffice.data-list-user');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        return $this->user->getAllUser($this->input('term'));
    }

    /**
     * @return array
     */
    public function setDemo()
    {
        $id = $this->input('id');
        $user = $this->user->findById($id);
        $this->user->setDemo($user);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Akun ' . $user->name . ' dinonaktifkan.',
        ];
    }

    /**
     * @return array
     */
    public function unsetDemo()
    {
        $id = $this->input('id');
        $user = $this->user->findById($id);
        $this->user->unsetDemo($user);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Akun ' . $user->name . ' telah aktif.',
        ];
    }

    /**
     * @return array
     */
    public function setActive()
    {
        $id = $this->input('id');
        $user = $this->user->findById($id);
        $this->user->setActive($user);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Akun ' . $user->name . ' telah aktif.',
        ];
    }

    /**
     * @return array
     */
    public function unsetActive()
    {
        $id = $this->input('id');
        $user = $this->user->findById($id);
        $this->user->unsetActive($user);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Akun ' . $user->name . ' telah dinonaktifkan.',
        ];
    }
}