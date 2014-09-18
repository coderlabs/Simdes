<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 7/30/2014
 * Time: 22:28
 */

namespace Profile;


use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class ProfileController
 * @package Profile
 */
class ProfileController extends \BaseController
{

    /**
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->auth = $auth;
    }

    /**
     *
     */
    public function index()
    {
        $data = $this->auth->findByOrganisasiId($this->auth->getOrganisasiId(), $this->auth->getUserId());
        //  1 -> administrator
        //  2 -> kepala desa
        //  3 -> sekretaris
        //  4 -> bendahara
        //  5 -> bendahara
        //  6 -> bendahara
        //  100 -> BackOffice Kab
        //  200 -> BackOffice Kec
        //  300 -> BackOffice Prov
        //  400 -> BackOffice Pusat
        $level_admin = "";
        switch ($level = $data->is_admin) {
            case 1 :
                $level_admin = 'Administrator';
                break;
            case 2 :
                $level_admin = 'Administrator';
                break;
            case 3 :
                $level_admin = 'Administrator';
                break;
            case 4 :
                $level_admin = 'Administrator';
                break;
            case 5 :
                $level_admin = 'Administrator';
                break;
            case 6 :
                $level_admin = 'Administrator';
                break;
            case 100 :
                $level_admin = 'Administrator Kabupaten';
                break;
            default :
                $level_admin = 'Guest';
        }
        $data['admin'] = $level_admin;

        $this->view('user.profile', ['data' => $data]);
    }

    /**
     *
     */
    public function passwordIndex()
    {
        $this->view('user.password');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $user = $this->auth->findByOrganisasiId($this->auth->getOrganisasiId(), $this->auth->getUserId());
        $form = $this->auth->getProfileEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'nama'  => $message->first('nama'),
                    'email' => $message->first('email'),
                ],
            ];
        }

        $data = $form->getInputData();

        // siapkan data hanya mengecek email dan password
        $credentials = [
            "email"    => \Input::get('email'),
            "password" => \Input::get('password')
        ];

        // cek apakah email dan password benar untuk memastikan
        // yang mengirim apakah benar dari user bersangkutan
        // hal ini sama dengan pada saat user sedang login
        if (!\Auth::attempt($credentials, false)) {
            return $this->redirectBack(['error_message' => true]);
        }

        // jika email dan user benar maka update profile
        $this->auth->updateProfileUser($user, $data);

        // jika sukses maka redirect back dan kirim flash success
        return $this->redirectBack(['success_message' => true]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postGantiPassword()
    {
        $user = $this->auth->findByOrganisasiId($this->auth->getOrganisasiId(), $this->auth->getUserId());
        $form = $this->auth->getGantiPasswordForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return $this->redirectBack([
                'validation' => [
                    'email'         => $message->first('email'),
                    'password'      => $message->first('password'),
                    'password_baru' => $message->first('password_baru'),
                ]
            ]);
        }

        $data = $form->getInputData();

        // siapkan data hanya mengecek email dan password
        $credentials = [
            "email"    => \Input::get('email'),
            "password" => \Input::get('password')
        ];

        // cek apakah email dan password benar untuk memastikan
        // yang mengirim apakah benar dari user bersangkutan
        // hal ini sama dengan pada saat user sedang login
        if (!\Auth::attempt($credentials, false)) {
            return $this->redirectBack(['message' => 'Password anda salah.']);
        }

        // jika email dan user benar maka update profile
        $this->auth->gantiPassword($user, $data);

        // jika sukses maka redirect back dan kirim flash success
        return $this->redirectBack([
            'message' => 'Sukses : Password berhasil di ubah, password anda saat ini : <b>' .
                \Input::get('password_baru') . '</b> gunakan untuk login.'
        ]);
    }


}