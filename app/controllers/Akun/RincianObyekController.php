<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 10:18
 */

namespace Akun;

use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class RincianObyekController
 *
 * @package controllers\Akun
 */
class RincianObyekController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Akun\RincianObyekRepositoryInterface
     */
    private $rincianObyek;

    /**
     * @param RincianObyekRepositoryInterface $rincianObyek
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        RincianObyekRepositoryInterface $rincianObyek,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();
        $this->beforeFilter('auth.post', ['on' => 'post']);

        $this->rincianObyek = $rincianObyek;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->rincianObyek->findAll($term = null, $this->auth->getOrganisasiId());
        $this->view('akun.data-rincian-obyek', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->rincianObyek->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->rincianObyek->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getForm();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'obyek_id'      => $message->first('obyek_id'),
                    'rincian_obyek' => $message->first('rincian_obyek')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->rincianObyek->create($data);

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
        $data = $this->rincianObyek->findById($id);

        return [
            'id'            => $data->id,
            'obyek_id'      => $data->obyek_id,
            'obyek'         => $data->obyek_id . '|' . $data->obyek->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'rincian_obyek' => $data->rincian_obyek
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $rincianObyek = $this->rincianObyek->findById($id);
        $form = $this->rincianObyek->getEditForm($rincianObyek->id);

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'obyek_id'      => $message->first('obyek_id'),
                    'rincian_obyek' => $message->first('rincian_obyek')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        return $this->rincianObyek->update($rincianObyek, $data);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        return $this->rincianObyek->delete($id,$this->auth->getOrganisasiId());
    }
}