<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 7/10/2014
 * Time: 15:47
 */

namespace User;

use Illuminate\Events\Dispatcher;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class UserCreateController
 * @package User
 */
class UserCreateController extends \BaseController
{

    /**
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        UserRepositoryInterface $auth,
        Dispatcher $event
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->event = $event;

    }

    /**
     * Menampilkan data user hanya boleh diakses oleh
     * user dengan tipe administrator
     *
     */
    public function index()
    {
        $this->view('user.data-user');
    }

    /**
     * Get All list user dikases via ajax
     *
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->auth->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * Method untuk simpan user baru hanya boleh diakses
     * oleh user dengan tipe administrator saja
     *
     * @return array
     */
    public function store()
    {
        $form = $this->auth->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            // is_fungsi sama dengan is_admin hanya alias untuk type hinting
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'email'     => $message->first('email'),
                    'password'  => $message->first('password'),
                    'name'      => $message->first('name'),
                    'slug'      => $message->first('slug'),
                    'is_fungsi' => $message->first('is_fungsi'),
                    'is_active' => $message->first('is_active'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $user = $this->auth->createUser($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan. Sebuah email konfirmasi dikirm ke alamat <b>' . $user->email . '<b/>',
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return $this->auth->findByOrganisasiId($this->auth->getOrganisasiId(), $id);
    }

    /**
     * Untuk reset password
     */
    public function resetPassword()
    {
        $form = $this->auth->getResetForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return \Redirect::route('auth.login')->with([
                'message' => $message->first('email')
            ]);
        }

        $email = $this->input('email');

        $data = $this->auth->findByEmail($email);

        if (!is_null($data)) {
            // event listen untuk kirim email reset password disini
            $this->event->fire('reset.password', $data);

            return \Redirect::route('auth.login')->with([
                'message' => 'Sebuah email konfirmasi telah dikirim ke email : <b>' . $email . '</b> jika anda tidak menerima email, periksa pada folder SPAM.'
            ]);
        } else {
            return \Redirect::route('auth.login')->with([
                'message' => 'Alamat email :<b>' . $email . '</b> tidak terdaftar di sistem.'
            ]);
        }

    }

    /**
     * Untuk aktifasi akun
     *
     * @param $email
     * @param $activation_code
     *
     * @return string
     */
    public function konfirmasiAkun($email, $activation_code)
    {
        $data = $this->auth->activationCode($email, $activation_code);

        if (!is_null($data)) {
            // event listen untuk kirim email pemeberitahun bahwa akun sudah aktiv
//            $this->event->fire('akun.aktif', $data);

            return \Redirect::route('auth.login')->with([
                'message' => 'Akun anda sudah aktif, silahkan login dengan email dan password anda'
            ]);
        } else {
            return \Redirect::route('auth.login')->with([
                'message' => 'Alamat email <b>' . $email . '</b> atau kode aktifasi tidak sesuai'
            ]);
        }

    }

    /**
     * @param $email
     * @param $remember_token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function konfirmResetPassword($email, $remember_token)
    {
        $data = $this->auth->resetPassword($email, $remember_token);

        if (!is_null($data)) {
            return \View::make('pages.reset-password', [
                'email'          => $email,
                'remember_token' => $remember_token,
                'id'             => $data->id,
                'message'        => 'Masukkan password dan konfirmasi password'
            ]);
        } else {
            return \Redirect::route('auth.login')->with([
                'message' => 'Alamat email <b>' . $email . '</b> atau token tidak sesuai'
            ]);
        }
    }

    public function postResetPassword()
    {
        $id = $this->input('id');
        $user = $this->auth->findById($id);
        $form = $this->auth->getResetPasswordForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'password' => $message->first('password'),
                ],
            ];

        }

        $data = $form->getInputData();
        $this->auth->updatePassword($user, $data);

        return \Redirect::route('auth.login')->with([
            'message' => 'Password berhasil di reset, login dengan email dan password yang baru'
        ]);

    }

    /**
     * @param $id
     * @return bool
     */
    public function show($id)
    {
        return false;
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $user = $this->auth->findById($id, $this->auth->getOrganisasiId());
        $form = $this->auth->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'email'     => $message->first('email'),
                    'name'      => $message->first('name'),
                    'slug'      => $message->first('slug'),
                    'is_fungsi' => $message->first('is_fungsi'),
                    'is_active' => $message->first('is_active'),
                ],
            ];

        }

        $data = $form->getInputData();
        $this->auth->userUpdate($user, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.',
        ];
    }

    public function destroy($id)
    {
        // tidak boleh menghapus user
        return [
            'Status' => 'Warning',
            'msg'    => 'Mohon maaf anda tidak diperkenankan untuk menghapus user saat ini.'
        ];

    }

    /**
     * @param $slug
     * @return array
     */
    public function cekSlug($slug)
    {
        $data = $this->auth->cekSlug($slug);

        if (!is_null($data)) {
            return ['user exist!'];
        } else {
            return ['user tersedia!'];
        }
    }

} 