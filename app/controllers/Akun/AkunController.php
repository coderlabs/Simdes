<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 08:56
 */

namespace Akun;

use Simdes\Repositories\Akun\AkunRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class AkunController
 *
 * @package controllers\Akun
 */
class AkunController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Akun\AkunRepositoryInterface
     */
    private $akun;

    /**
     * @param AkunRepositoryInterface $akun
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        AkunRepositoryInterface $akun,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();
        $this->beforeFilter('auth.post', ['on' => 'post']);

        $this->akun = $akun;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->akun->findAll($term = null);
        $this->view('akun.data-akun', compact('data'));
    }

    /**
     * Filter berdasarkan organisasi_id belum bisa dilakukan
     * masih diperhitungkan jika multi organisasi
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        return $this->akun->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->akun->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getForm();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'akun'          => $message->first('akun')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getUserId();

        // dalam masa percobaan akan dinonaktifkan
        // fitur create, update dan delete
        // todo : aktifkan kembali
        // $this->akun->create($data);

        // kembalikan return bahwa ini adalah demo
        return [
            'Status' => 'Warning',
            'msg'    => 'Mohon maaf anda tidak diperkenankan untuk melakukan aksi ini'
        ];
    }

    /**
     * Filter berdasarkan organisasi_id
     * masih belum berlaku saat ini
     * @param $id
     *
     * @return array
     */
    public function edit($id)
    {
        return $this->akun->findByFilter($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $akun = $this->akun->findById($id);
        $form = $this->akun->getEditForm($akun->id);

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'akun'          => $message->first('akun')
                ]
            ];
        }

        $data = $form->getInputData();
        // dalam masa percobaan akan dinonaktifkan
        // fitur create, update dan delete
        // todo : aktifkan kembali
        // kembalikan return bahwa ini adalah demo
        return [
            'Status' => 'Warning',
            'msg'    => 'Mohon maaf anda tidak diperkenankan untuk melakukan aksi ini'
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        return $this->akun->delete($id);
    }
}