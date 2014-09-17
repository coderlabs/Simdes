<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 7/21/2014
 * Time: 11:13
 */

namespace Simdes\Repositories\User;


interface AuthRepositoryInterface {

    public function attempt($credentials, $remember);

    public function isLogin($user_id);

    public function isExists($slug);

    public function sendEmail();

    public function getActivationCode($organisasi_id);

    public function cek();

    public function getUserId();

    public function getOrganisasiId();
}