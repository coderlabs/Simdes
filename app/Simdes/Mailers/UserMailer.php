<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 7/23/2014
 * Time: 13:10
 */

namespace Simdes\Mailers;

use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;


/**
 * Class UserMailer
 * @package Simdes\Mailers
 */
class UserMailer
{

    private $pejabat;

    public function __construct(
        PejabatDesaRepositoryInterface $pejabat
    )
    {
        $this->pejabat = $pejabat;
    }

    /**
     * Method untuk mengirimkan email ketika User
     * mendaftarkan organisasi dan mendapatkan
     * informasi dari organisasi dan email
     *
     * todo akan dikirim code aktivasi via email
     *
     * @return void
     */
    public function welcome($data)
    {
//        \Mail::pretend();

        $user = array(
            'email'           => $data->email,
            'nama'            => $data->name,
            'activation_code' => $data->activation_code,
            'organisasi_id'   => $data->organisasi_id,
        );

        $data = array(
            'nama'            => $user['nama'],
            'email'           => $user['email'],
            'activation_code' => $user['activation_code'],
            'organisasi_id'   => $user['organisasi_id']
        );

        // kirim email ke user administrator pada waktu pertama kali daftar
        \Mail::send('emails.welcome', $data, function ($message) use ($user) {
            $message->to($user['email'], $user['nama'])->subject('Selamat Registrasi anda berhasil');
        });

        // siapkan data untuk input pejabat Kepala Desa dan
        // Sekretaris Desa untuk pertama kali pendaftaran
        $dt = [
            'nama'          => 'Mr Kepala Desa',
            'jabatan'       => 'Kepala Desa',
            'tanggal_sk'    => '0000-00-00',
            'judul'         => '',
            'nip'           => '',
            'nomer_sk'      => '',
            'fungsi'        => 'Pemegang Kuasa Anggaran',
            'pejabat'       => 'Bupati',
            'organisasi_id' => $user['organisasi_id'],
        ];

        $this->pejabat->create($dt);
    }

    public function createUser($data)
    {
//        \Mail::pretend();

        $user = array(
            'email'           => $data->email,
            'nama'            => $data->name,
            'activation_code' => $data->activation_code,
            'organisasi_id'   => $data->organisasi_id,
        );

        $data = array(
            'nama'            => $user['nama'],
            'email'           => $user['email'],
            'activation_code' => $user['activation_code'],
            'organisasi_id'   => $user['organisasi_id']
        );

        \Mail::send('emails.user-create', $data, function ($message) use ($user) {
            $message->to($user['email'], $user['nama'])->subject('Pendaftaran User baru');
        });
    }

    public function resetPassword($data)
    {
//        \Mail::pretend();

        $user = array(
            'email'           => $data->email,
            'nama'            => $data->name,
            'activation_code' => $data->activation_code,
            'remember_token'  => $data->remember_token,
            'organisasi_id'   => $data->organisasi_id,
        );

        $data = array(
            'nama'            => $user['nama'],
            'email'           => $user['email'],
            'remember_token'  => $user['remember_token'],
            'activation_code' => $user['activation_code'],
            'organisasi_id'   => $user['organisasi_id']
        );

        \Mail::send('emails.reset-password', $data, function ($message) use ($user) {
            $message->to($user['email'], $user['nama'])->subject('Email Konfirmasi Reset Password');
        });
    }
}