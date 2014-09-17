<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/2/2014
 * Time: 19:19
 */

namespace Pejabat;

use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface as PejabatDesa;
use Simdes\Repositories\User\UserRepositoryInterface as UserAuth;

/**
 * Class PejabatDesaController
 * @package Pejabat
 */
class PejabatDesaController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    private $pejabat;

    /**
     * @param UserAuth $auth
     * @param PejabatDesa $pejabat
     */
    public function __construct(UserAuth $auth, PejabatDesa $pejabat)
    {
       parent::__construct();

        $this->auth = $auth;
        $this->pejabat = $pejabat;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->view('pejabat.pejabat-desa');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        return $this->pejabat->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->pejabat->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'nama'       => $message->first('nama'),
                    'fungsi'     => $message->first('fungsi'),
                    'jabatan'    => $message->first('jabatan'),
                    'pejabat'    => $message->first('pejabat'),
                    'tanggal_sk' => $message->first('tanggal_sk')
                ],
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->pejabat->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pejabat = $this->pejabat->findById($id, $this->auth->getOrganisasiId());
        $form = $this->pejabat->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'nama'       => $message->first('nama'),
                    'fungsi'     => $message->first('fungsi'),
                    'jabatan'    => $message->first('jabatan'),
                    'pejabat'    => $message->first('pejabat'),
                    'tanggal_sk' => $message->first('tanggal_sk')
                ],
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->pejabat->update($pejabat, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function edit($id)
    {
        $data = $this->pejabat->findById($id, $this->auth->getOrganisasiId());

        return [
            'id'         => $data->id,
            'nama'       => $data->nama,
            'nip'        => $data->nip,
            'jabatan'    => $data->jabatan,
            'nomer_sk'   => $data->nomer_sk,
            'judul'      => $data->judul,
            'fungsi'     => $data->fungsi,
            'pejabat'    => $data->pejabat,
            'tanggal_sk' => date('d-m-Y', strtotime($data->tanggal_sk))
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->pejabat->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

    /**
     * todo akan diubah where clause hanya memakasi user_id
     * @param $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        $data = $this->auth->findBySlug($this->auth->getUserId(), $slug);

        $this->view('user.user-profile',['data' => $data]);
    }
}