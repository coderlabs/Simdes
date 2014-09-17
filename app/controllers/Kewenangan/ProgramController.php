<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/29/2014
 * Time: 13:30
 */

namespace Kewenangan;

use Simdes\Repositories\Kewenangan\ProgramRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KewenanganController
 * @package Kewenangan
 */
class ProgramController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Kewenangan\ProgramRepositoryInterface
     */
    protected $program;

    /**
     * @param UserRepositoryInterface $auth
     * @param ProgramRepositoryInterface $program
     */
    public function __construct(
        UserRepositoryInterface $auth,
        ProgramRepositoryInterface $program
    )
    {
        parent::__construct();
        $this->auth = $auth;
        $this->program = $program;
    }

    /**
     * Menampilkan list Program
     */
    public function index()
    {
        $data = $this->program->findAll($term = null, $this->auth->getOrganisasiId());
        $this->view('kewenangan.data-program', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->program->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->program->getCreationForm();

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
        $this->program->create($data);

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
        $data = $this->program->findById($id);

        return [
            'id'            => $data->id,
            'fungsi_id'     => $data->bidang->fungsi_id,
            'bidang_id'     => $data->bidang_id,
            'bidang'        => $data->bidang_id . '|' . $data->bidang->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'program'       => $data->program
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $kewenangan = $this->program->findById($id);
        $form = $this->program->getEditForm();

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

        return $this->program->update($kewenangan, $data);

    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->program->delete($id,$this->auth->getOrganisasiId());
    }
}