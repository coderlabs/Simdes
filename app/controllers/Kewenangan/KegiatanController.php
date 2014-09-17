<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/29/2014
 * Time: 13:30
 */

namespace Kewenangan;

use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KewenanganController
 * @package Kewenangan
 */
class KegiatanController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Kewenangan\ProgramRepositoryInterface
     */
    protected $kegiatan;

    /**
     * @param UserRepositoryInterface $auth
     * @param KegiatanRepositoryInterface $kegiatan
     */
    public function __construct(
        UserRepositoryInterface $auth,
        KegiatanRepositoryInterface $kegiatan
    )
    {
        parent::__construct();
        $this->auth = $auth;
        $this->kegiatan = $kegiatan;
    }

    /**
     * Menampilkan list Program
     */
    public function index()
    {
        $data = $this->kegiatan->findAll($term = null, $this->auth->getOrganisasiId());

        $this->view('kewenangan.data-kegiatan', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->kegiatan->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->kegiatan->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'bidang_id'     => $message->first('bidang_id'),
                    'program'       => $message->first('program'),
                    'kode_rekening' => $message->first('kode_rekening'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->kegiatan->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];

    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = $this->kegiatan->findById($id);

        return [
            'fungsi_id'     => $data->program->bidang->fungsi_id,
            'bidang_id'     => $data->program->bidang_id,
            'id'            => $data->id,
            'program_id'    => $data->program_id,
            'program'       => $data->program_id . '|' . $data->program->kode_rekening,
            'kegiatan'      => $data->kegiatan,
            'kode_rekening' => $data->kode_rekening,
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $kewenangan = $this->kegiatan->findById($id);
        $form = $this->kegiatan->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'bidang'        => $message->first('bidang'),
                    'program'       => $message->first('program'),
                    'kode_rekening' => $message->first('kode_rekening'),
                ],
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        return $this->kegiatan->update($kewenangan, $data);
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->kegiatan->delete($id, $this->auth->getOrganisasiId());
    }
}