<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 10:09
 */

namespace Akun;

use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class ObyekController
 *
 * @package controllers\Akun
 */
class ObyekController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Akun\ObyekRepositoryInterface
     */
    private $obyek;

    /**
     * @param ObyekRepositoryInterface $obyek
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        ObyekRepositoryInterface $obyek,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();
        $this->beforeFilter('auth.post', ['on' => 'post']);

        $this->obyek = $obyek;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->obyek->findAll($term = null, $this->auth->getOrganisasiId());
        $this->view('akun.data-obyek', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->obyek->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->obyek->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'jenis_id'      => $message->first('jenis_id'),
                    'obyek'         => $message->first('obyek'),
                    'regulasi'      => $message->first('regulasi'),
                    'pengundangan'  => $message->first('pengundangan'),
                    'tanggal'       => $message->first('tanggal')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->obyek->create($data);

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
        $data = $this->obyek->findByFilter($id, $this->auth->getOrganisasiId());

        return [
            'id'            => $data->id,
            'jenis_id'      => $data->jenis_id,
            'jenis'         => $data->jenis_id . '|' . $data->jenis->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'obyek'         => $data->obyek,
            'pengundangan'  => $data->pengundangan,
            'tanggal'       => $data->tanggal,
            'regulasi'      => $data->regulasi,

        ];

    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $obyek = $this->obyek->findById($id);
        $form = $this->obyek->getEditForm($obyek->id);

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'jenis_id'      => $message->first('jenis_id'),
                    'obyek'         => $message->first('obyek'),
                    'regulasi'      => $message->first('regulasi'),
                    'pengundangan'  => $message->first('pengundangan'),
                    'tanggal'       => $message->first('tanggal')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        return $this->obyek->update($obyek, $data);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        return $this->obyek->delete($id, $this->auth->getOrganisasiId());
    }
}