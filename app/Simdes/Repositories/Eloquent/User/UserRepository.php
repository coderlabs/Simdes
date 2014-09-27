<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 16:06
 */

namespace Simdes\Repositories\Eloquent\User;


use Illuminate\Auth\AuthManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Simdes\Models\User\User;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;
use Simdes\Services\Forms\User\CreateNewUserForm;
use Simdes\Services\Forms\User\CredentialsForm;
use Simdes\Services\Forms\User\EditUserForm;
use Simdes\Services\Forms\User\GantiPasswordForm;
use Simdes\Services\Forms\User\KonfirmasiForm;
use Simdes\Services\Forms\User\ProfileEditForm;
use Simdes\Services\Forms\User\RegistrationForm;
use Simdes\Services\Forms\User\ResetForm;
use Simdes\Services\Forms\User\ResetPasswordForm;

/**
 * Class UserRepository
 *
 * @package Simdes\Repositories\Eloquent\User
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    private $organisasi;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var Dispatcher
     */
    private $event;

    /**
     * @param User $user
     * @param OrganisasiRepositoryInterface $organisasi
     * @param AuthManager $auth
     * @param Dispatcher $event
     */
    public function __construct(
        User $user,
        OrganisasiRepositoryInterface $organisasi,
        AuthManager $auth,
        Dispatcher $event
    )
    {
        $this->model = $user;
        $this->organisasi = $organisasi;
        $this->auth = $auth;
        $this->event = $event;
    }

    /**
     * Get List user by Organisasi_id
     *
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function getByOrganisasiId($term, $organisasi_id)
    {
        return $this->model
            ->FullTextSearch($term)
            ->where('organisasi_id', '=', $organisasi_id)
            ->orderBy('id','desc')
            ->remember(10)
            ->paginate(10,['id','name','email','is_admin','is_demo','is_active']);
    }

    /**
     * Diakses oleh user dengan tipe backoffice
     *
     * @param $term
     * @return mixed
     */
    public function getAllUser($term)
    {
        return $this->model
            // penerapan pencarian dengan teknik Full Text Search
            ->FullTextSearch($term)
            // get list user kecuali user dengan tipe is_admin = 100
            // ini adalah admin tingkat kabupaten
            ->where('is_admin', '!=', 100)
            // order by id user terakhir mendaftar
            ->orderBy('id', 'desc')
            // save cache
//            ->remember(10)
            ->paginate(10,['id','name','email','is_admin','organisasi_id','is_demo','is_active']);
    }

    /**
     * @param User $user
     * @return User
     */
    public function setDemo(User $user)
    {
        // jadikan akun ini demo, diaktifkan oleh bakcoffice
        $user->is_demo = 1;
        $user->save();
        return $user;

    }

    /**
     * @param User $user
     * @return User
     */
    public function unsetDemo(User $user)
    {
        // jadikan akun tidak demo, akun bisa digunakan
        $user->is_demo = 0;
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function setActive(User $user)
    {
        // jadikan akun active
        $user->is_active = 2;
        $user->save();
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function unsetActive(User $user)
    {
        // jadikan akun not active
        $user->is_active = 1;
        $user->save();
        return $user;
    }

    /**
     * Create user Administrator pada
     * waktu pertama kali daftar
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        // instance model
        $user = $this->getNew();

        // set param email
        $user->email = e($data['email']);

        // set default is_admin = 1 akun tipe administrator
        $user->is_admin = 1;

        // is_active = 1 berarti akun belum aktif, harus diaktifkan dengan membuka email notifikasi
        // is_active = 2 berarti akun sudah aktif
        $user->is_active = 1;

        // is_demo = 0 berarti akun aktif, is_demo hanya bisa diaktifkan oleh backoffice
        $user->is_demo = 0;

        // siapkan input nama
        $user->name = e(ucwords(strtolower($data['name'])));

        // siapkan input password yang di hash
        $user->password = Hash::make($data['password']);

        // activation code adalah code generate dari str_random(60)
        // kode ini berfungsi untuk mengaktifkan akun melalui
        // email, jika link/url diklick dan akun akan aktif
        $user->activation_code = str_random(60);

        $user->save();

        // selanjutnya untuk input data ke table organisasi
        // data yang akan diinput ke organisasi dari user
        // email; organisasi;return berupa organisasi_id
        $data['organisasi'] = e(ucfirst($data['organisasi']));
        $data['email'] = e($data['email']);

        // create organisasi return berupa organisasi_id
        $organisasi_id = $this->organisasi->create($data);

        // siapkan data berupa organisasi_id yang didapat dari
        // hasil return setelah input_organisasi
        $up_user = $this->findById($user->id);
        $data_up['organisasi_id'] = $organisasi_id;

        // update user dengan organisasi_id yang didapat
        $this->updateUser($up_user, $data_up);

        // siapkan organsiasi_id untuk diinputkan ke pejabat
        // yang akan diumpankan ke event listen user.signup
        $user['organisasi_id'] = $organisasi_id;

        // event listen untuk mengirimkan email dengan data $user
        $this->event->fire('user.signup', $user);

        return $user;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param User $user
     * @param      $data
     *
     * @return User
     */
    public function updateUser(User $user, $data)
    {
        $user->organisasi_id = strip_tags(trim(ucfirst($data['organisasi_id'])));
        $user->save();

        return $user;
    }


    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, $data)
    {
        $fungsi = e($data['fungsi']);

        $user->is_pejabat = 1;
        $user->is_organisasi = 1;
        $user->organisasi = e($data['organisasi']);
        $user->is_fungsi = $this->getFungsi($fungsi);
        $user->name = e(ucwords(strtolower($data['name'])));
        $user->organisasi_id = e($data['organisasi_id']);

        $user->save();

        return $user;
    }

    /**
     * @param $fungsi
     * @return string
     */
    public function getFungsi($fungsi)
    {
        switch ($fungsi) {
            case "Pemegang Kuasa Anggaran":
                return "2";
                break;
            case "Pejabat Pelaksana Kegiatan":
                return "3";
                break;
            case "Pejabat Pelaksana Teknis Keuangan":
                return "4";
                break;
            case "Bendahara Desa":
                return "5";
                break;
            case "Bendahara Pembantu Penerimaan":
                return "6";
                break;
            case "Bendahara Pembantu Pengeluaran":
                return "7";
                break;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return false;
    }

    /**
     * @return RegistrationForm
     */
    public function getRegistrationForm()
    {
        return new RegistrationForm();
    }

    /**
     *
     */
    public function getEditForm()
    {
        return new EditUserForm();
    }

    /**
     * @return ResetPasswordForm
     */
    public function getResetPasswordForm()
    {
        return new ResetPasswordForm();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->auth->user()->id;
    }

    /**
     * @return mixed
     */
    public function getOrganisasiId()
    {
        return $this->auth->user()->organisasi_id;
    }

    /**
     * @return mixed
     */
    public function getKabIdByOrganisasiId()
    {
        return $this->auth->user()->organisasi->kode_kab;
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function UpdateIsPejabat(User $user, array $data)
    {
        $user->is_pejabat = 1;
        $user->save();
        return $user;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createNew(array $data)
    {
        $user = $this->getNew();

        // ketentuan fungsi
        // 0 - superadmin
        // 1 - administrator
        // 2 - kepala desa | Pemegang Kuasa Anggaran
        // 3 - sekretaris desa | Pejabat Pelaksana Kegiatan
        // 4 - bendahara umum | Pejabat Pelaksana Teknis Keuangan
        // 5 - Bendahara Desa
        // 6 - Bendahara Pembantu Penerimaan
        // 7 - Bendahara Pembantu Pengeluaran

        $fungsi = e($data['fungsi']);

        $user->email = e($data['email']);
        $user->is_pejabat = 1;
        $user->is_organisasi = 1;
        $user->organisasi = e($data['organisasi']);
        $user->is_fungsi = $this->getFungsi($fungsi);
        $user->name = e(ucwords(strtolower($data['name'])));
        $user->organisasi_id = e($data['organisasi_id']);
        $user->password = Hash::make($data['password']);

        // todo: tidak jadi gunakan slug -> nanti akan dihapus
        $user->slug = Str::slug(strtolower($data['name']), '-');
        $user->save();

        return $user->id;
    }

    /**
     * @param $user_id
     * @param $slug
     * @return mixed
     */
    public function findBySlug($user_id, $slug)
    {
        return $this->model->where('id', '=', $user_id)->where('slug', '=', $slug)->first();
    }

    /**
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', '=', $email)->first();
    }

    /**
     * @param $email
     * @param $activation_code
     * @return mixed
     */
    public function activationCode($email, $activation_code)
    {
        $data = $this->model->where('email', '=', $email)->where('activation_code', '=', $activation_code)->first();

        if (!is_null($data)) {
            // update jika data ditemukan is_active 1 berati aktif
            $data->is_active = '2';

            // is_demo 0 berati aktif
            $data->is_demo = '0';
            $data->save();

            return $data;
        }
    }

    /**
     * @param $email
     * @param $remember_token
     * @return mixed
     */
    public function resetPassword($email, $remember_token)
    {
        return $this->model->where('email', '=', $email)->where('remember_token', '=', $remember_token)->first();
    }

    /**
     * @param $organisasi_id
     * @param $user_id
     * @return mixed
     */
    public function findByOrganisasiId($organisasi_id, $user_id)
    {
        return $this->model
            ->where('id', '=', $user_id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->with('organisasi')
            ->remember(10)
            ->first();
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createUser(array $data)
    {
        $user = $this->getNew();

        $user->email = e($data['email']);

        // code untuk aktivasi user memakai email yang digenerate str_random(60)
        $user->activation_code = str_random(60);
        $user->password = Hash::make(e($data['password']));
        $user->name = e($data['name']);

        // is_fungsi = is_admin hanya untuk type hinting data di font end
        // sebelumnya di validasi tidak boleh lebih dari angka 10
        $user->is_admin = e($data['is_fungsi']);

        // is_active default adalah 1 = tidak active
        $user->is_active = e($data['is_active'], 1);

        $user->organisasi_id = e($data['organisasi_id']);
        $user->save();

        // event listen untuk mengirimkan email
        $this->event->fire('user.create', $user);
        return $user;
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function userUpdate(User $user, array $data)
    {
        $user->email = e($data['email']);

        $user->name = e($data['name']);

        // is_fungsi = is_admin hanya untuk type hinting data di font end
        // sebelumnya di validasi tidak boleh lebih dari angka 10
        $user->is_admin = e($data['is_fungsi']);

        // is_active default adalah 1 = tidak active
        $user->is_active = e($data['is_active'], 1);

        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updatePassword(User $user, array $data)
    {
        // reset password
        $user->password = Hash::make(e($data['password']));
        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function gantiPassword(User $user, array $data)
    {
        // reset password
        $user->password = \Hash::make(e($data['password_baru']));
        $user->save();

        return $user;
    }

    /**
     * Cek apakah slug tersedia apa tidak? slug harus unique secara
     * default diambil dari nama yang kemudian dicek via ajax dan
     * juga bisa input secara manual system akan cek via ajax
     *
     * @param $slug
     * @return mixed
     */
    public function cekSlug($slug)
    {
        return $this->model->where('slug', '=', $slug)->first();
    }

    /**
     * @return CreateNewUserForm
     */
    public function getCreationForm()
    {
        return new CreateNewUserForm();
    }

    /**
     * @return EditUserForm
     */
    public function getEditUserForm()
    {
        return new EditUserForm();
    }

    /**
     * @return ProfileEditForm
     */
    public function getProfileEditForm()
    {
        return new ProfileEditForm();
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateProfileUser(User $user, array $data)
    {
        $user->email = e($data['email']);
        $user->name = e($data['name']);
        $user->save();

        return $user;
    }

    /**
     * @return ResetForm
     */
    public function getResetForm()
    {
        return new ResetForm();
    }

    /**
     * @return CredentialsForm
     */
    public function getCredentialsForm()
    {
        return new CredentialsForm();
    }

    /**
     * @return GantiPasswordForm
     */
    public function getGantiPasswordForm()
    {
        return new GantiPasswordForm();
    }

    /**
     * @return KonfirmasiForm
     */
    public function getKonfirmasiForm()
    {
        return new KonfirmasiForm();
    }
}