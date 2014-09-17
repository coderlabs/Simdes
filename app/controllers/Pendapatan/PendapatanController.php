<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/14
 * Time: 10:45 AM
 */

namespace Pendapatan;

use Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class PendapatanController
 *
 * @package Pendapatan
 */
class PendapatanController extends \BaseController
{

    /**
     * @var
     */
    private $pendapatan;

    /**
     * @param PendapatanRepositoryInterface $pendapatan
     * @param UserRepositoryInterface $auth
     */
    function __construct(
        PendapatanRepositoryInterface $pendapatan,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->pendapatan = $pendapatan;
        $this->auth = $auth;
    }


    /**
     * @return mixed
     */
    public function index()
    {
        $this->view('pendapatan.data-pendapatan');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->pendapatan->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->pendapatan->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'tahun'            => $message->first('tahun'),
                    'kelompok_id'      => $message->first('kelompok_id'),
                    'jenis_id'         => $message->first('jenis_id'),
                    'obyek_id'         => $message->first('obyek_id'),
                    'rincian_obyek_id' => $message->first('rincian_obyek_id'),
                    'volume_1'         => $message->first('volume_1'),
                    'satuan_1'         => $message->first('satuan_1'),
                    'satuan_harga'     => $message->first('satuan_harga')
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->pendapatan->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->pendapatan->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-pendapatan');
        } else {
            $this->view('pendapatan.detail-pendapatan', compact('data'));
        }
    }


    /**
     * @param $id
     *
     * @return array
     */
    public function edit($id)
    {
        return $data = $this->pendapatan->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->pendapatan->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->pendapatan->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'tahun'            => $message->first('tahun'),
                    'kelompok_id'      => $message->first('kelompok_id'),
                    'jenis_id'         => $message->first('jenis_id'),
                    'obyek_id'         => $message->first('obyek_id'),
                    'rincian_obyek_id' => $message->first('rincian_obyek_id'),
                    'volume_1'         => $message->first('volume_1'),
                    'satuan_1'         => $message->first('satuan_1'),
                    'satuan_harga'     => $message->first('satuan_harga')
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->pendapatan->update($pendapatan, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        $this->pendapatan->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

    /**
     * Seting rka Desa
     * jika dalam waktu 7 hari setelah update rka belum disetujui maka secara
     * otomatis status dari rka menjadi dpa
     * todo:perlu evaluasi
     *
     * @return array
     */
    public function setRKA()
    {
        $id = $this->input("id");
        $this->pendapatan->setRKA($id);
        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : rka Desa sudah diseting.',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function setHistory($id)
    {
        $pendapatan = $this->pendapatan->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->pendapatan->getHistoryForm();

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->pendapatan->setHistory($pendapatan, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];
    }
}