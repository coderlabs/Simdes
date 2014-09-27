<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 16:01
 */

namespace Simdes\Repositories\User;


use Simdes\Models\User\User;

/**
 * Interface UserRepositoryInterface
 *
 * @package Simdes\Repositories\User
 */
interface UserRepositoryInterface
{

    /**
     * Menampilkan data user berdasarkan param
     * dan juga pada waktu di pencarian form
     *
     * @param $term
     *
     * @return mixed
     */
    public function getByOrganisasiId($term, $organisasi_id);

    /**
     * Diakses oleh user dengan tipe backoffice
     *
     * @param $term
     * @return mixed
     */
    public function getAllUser($term);

    /**
     * Set User sebagai Demo ini digunakan untuk pemblokiran
     * Jika trafik aplikasi besar, dan hanya digunakan
     * oleh user yang sedang menjalani pelatihan
     *
     * @param User $user
     * @return mixed
     */
    public function setDemo(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function unsetDemo(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function setActive(User $user);

    /**
     * @param User $user
     * @return mixed
     */
    public function unsetActive(User $user);

    /**
     * Create user baru oleh administrator
     * default dari rule ini is_admin = 0
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * Pencarian data berdasarkan id
     *
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * Update data user oleh Administrator
     *
     * @param User $user
     * @param array $data
     *
     * @return mixed
     */
    public function update(User $user, $data);

    /**
     * Hapus user
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * get Form Registrasi ketika
     *
     * pertama kali daftar
     * @return mixed
     */
    public function getRegistrationForm();

    /**
     * Get Edit Form user oleh administrator
     *
     * @return mixed
     */
    public function getEditForm();

    /**
     * @return mixed
     */
    public function getResetPasswordForm();

    /**
     * Get user_id untuk keperluan di Controller
     * todo : nanti akan diambil dari session
     *
     * @return mixed
     */
    public function getUserId();

    /**
     * Get organisasi_id untuk keperluan di Controller
     * todo : nanti akan diambil dari session
     * @return mixed
     */
    public function getOrganisasiId();

    /**
     * @return mixed
     */
    public function getKabIdByOrganisasiId();

    /**
     * Untuk cek apakah sudah memiliki pejabat
     * todo : akan dihapus
     * @param User $user
     * @param array $data
     * @return mixed
     */
    public function UpdateIsPejabat(User $user, array $data);

    /**
     * todo : akan dievaluasi
     *
     * @param array $data
     * @return mixed
     */
    public function createNew(array $data);

    /**
     * todo : akan dihapus untuk mengefektifkan
     *
     * query dan pikiran agar tidak terbebani
     * @param $user_id
     * @param $slug
     * @return mixed
     */
    public function findBySlug($user_id, $slug);

    /**
     * Create  New  User
     *
     * todo : evaluasi
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data);

    /**
     * todo : akan dihapus
     *
     * @param $slug
     * @return mixed
     */
    public function cekSlug($slug);

    /**
     * Get Form untuk create New user
     *
     * @return mixed
     */
    public function getCreationForm();

    /**
     * Get Form Edit user
     *
     * @return mixed
     */
    public function getEditUserForm();

    /**
     * Update Profile nama dan email saja
     *
     * @param User $user
     * @param array $data
     * @return mixed
     */
    public function userUpdate(User $user, array $data);

    /**
     * @param User $user
     * @param array $data
     * @return mixed
     */
    public function updatePassword(User $user, array $data);

    /**
     * @param User $user
     * @param array $data
     * @return mixed
     */
    public function gantiPassword(User $user, array $data);

    /**
     * Find User By Organisasi_id dan user id
     * untuk keperluan query pada profile
     *
     * @param $organisasi_id
     * @param $user_id
     * @return mixed
     */
    public function findByOrganisasiId($organisasi_id, $user_id);

    /**
     * Update Profile user nama dan email
     *
     * @param User $user
     * @param array $data
     * @return mixed
     */
    public function updateProfileUser(User $user, array $data);

    /**
     * Get Form edit profile
     *
     * @return mixed
     */
    public function getProfileEditForm();

    /**
     * @return mixed
     */
    public function getResetForm();

    /**
     * @return mixed
     */
    public function getCredentialsForm();

    /**
     * @return mixed
     */
    public function getGantiPasswordForm();

    /**
     * @return mixed
     */
    public function getKonfirmasiForm();

    /**
     * @param $email
     * @return mixed
     */
    public function findByEmail($email);

    /**
     * @param $email
     * @param $activation_code
     * @return mixed
     */
    public function activationCode($email, $activation_code);

    /**
     * @param $email
     * @param $remember_token
     * @return mixed
     */
    public function resetPassword($email, $remember_token);

}