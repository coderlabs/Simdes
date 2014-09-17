<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 8/8/2014
 * Time: 13:52
 */

namespace Transaksi;


use Simdes\Repositories\User\UserRepositoryInterface;

class LaporanPendapatanController extends \BaseController{

    public function __construct(UserRepositoryInterface $auth){
        parent::__construct();

        $this->auth = $auth;
    }


    public function index(){
        $this->view('transaksi.laporan');
    }

    public function laporan(){

    }

} 