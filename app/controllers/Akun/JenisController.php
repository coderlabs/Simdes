<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 09:56
 */

namespace Akun;

use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class JenisController
 *
 * @package controllers\Akun
 */
class JenisController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Akun\JenisRepositoryInterface
     */
    private $jenis;

    /**
     * @param JenisRepositoryInterface $jenis
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        JenisRepositoryInterface $jenis,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();
        $this->beforeFilter('auth.post', ['on' => 'post']);

        $this->jenis = $jenis;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->jenis->findAll($term = null);
        $this->view('akun.data-jenis', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->jenis->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->jenis->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kelompok_id'   => $message->first('kelompok_id'),
                    'referensi'     => $message->first('referensi'),
                    'jenis'         => $message->first('jenis')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();

        $this->jenis->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan'
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function edit($id)
    {
        $data = $this->jenis->findById($id);

        return [
            'id'            => $data->id,
            'kelompok_id'   => $data->kelompok_id,
            'kelompok'      => $data->kelompok_id . '|' . $data->kelompok->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'jenis'         => $data->jenis,
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $jenis = $this->jenis->findById($id);
        $form = $this->jenis->getEditForm($jenis->id);

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kelompok_id'   => $message->first('kelompok_id'),
                    'referensi'     => $message->first('referensi'),
                    'jenis'         => $message->first('jenis')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->jenis->update($jenis, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        return $this->jenis->delete($id);
    }
}