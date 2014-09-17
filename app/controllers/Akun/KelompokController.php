<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 09:47
 */

namespace Akun;

use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KelompokController
 *
 * @package controllers\Akun
 */
class KelompokController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Akun\KelompokRepositoryInterface
     */
    private $kelompok;

    /**
     * @param KelompokRepositoryInterface $kelompok
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        KelompokRepositoryInterface $kelompok,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();
        $this->beforeFilter('auth.post', ['on' => 'post']);

        $this->kelompok = $kelompok;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->kelompok->findAll($term = null);
        $this->view('akun.data-kelompok', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->kelompok->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->kelompok->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getForm();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'akun_id'       => $message->first('akun_id'),
                    'kelompok'      => $message->first('kelompok')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->kelompok->create($data);

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
        $data = $this->kelompok->findByFilter($id, $this->auth->getOrganisasiId());
        return [
            'id'            => $data->id,
            'akun_id'       => $data->akun_id,
            'akun'          => $data->akun_id . '|' . $data->akun->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'kelompok'      => $data->kelompok
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $kelompok = $this->kelompok->findById($id);
        $form = $this->kelompok->getEditForm($kelompok->id);

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'akun_id'       => $message->first('akun_id'),
                    'kelompok'      => $message->first('kelompok')
                ]
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->kelompok->update($kelompok, $data);

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
        return $this->kelompok->delete($id);
    }
}