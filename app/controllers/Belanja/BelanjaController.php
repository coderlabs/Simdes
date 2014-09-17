<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/19/2014
 * Time: 08:03
 */

namespace Belanja;

use Simdes\Repositories\Belanja\BelanjaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class BelanjaController
 *
 * @package controllers\Belanja
 */
class BelanjaController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Belanja\BelanjaRepositoryInterface
     */
    private $belanja;

    /**
     * @param UserRepositoryInterface $auth
     * @param BelanjaRepositoryInterface $belanja
     */
    public function __construct(
        UserRepositoryInterface $auth,
        BelanjaRepositoryInterface $belanja
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->belanja = $belanja;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->view('belanja.data-belanja');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->belanja->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->belanja->getCreationForm();

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
        $this->belanja->create($data);

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
        $data = $this->belanja->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-belanja');
        } else {
            $this->view('belanja.detail-belanja', compact('data'));
        }
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function edit($id)
    {
        $data = $this->belanja->findByFilter($id, $this->auth->getOrganisasiId());

        return $result = [
            'id'               => $data->id,
            'tahun'            => $data->tahun,
            'kegiatan'         => $data->kegiatan_id . '|' . $data->rkpdesa_id . '|' . $data->pagu_anggaran,
            'jumlah'           => $data->jumlah,
            'kegiatan_id'      => $data->kegiatan_id,
            'rkpdesa_id'       => $data->rkpdesa_id,
            'pagu_anggaran'    => $data->pagu_anggaran,
            'kelompok_id'      => $data->kelompok_id,
            'jenis_id'         => $data->jenis_id,
            'obyek_id'         => $data->obyek_id,
            'rincian_obyek_id' => $data->rincian_obyek_id,
            'volume_1'         => $data->volume_1,
            'satuan_1'         => $data->satuan_1,
            'volume_2'         => $data->volume_2,
            'satuan_2'         => $data->satuan_2,
            'volume_3'         => $data->volume_3,
            'satuan_3'         => $data->satuan_3,
            'satuan_harga'     => $data->satuan_harga
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $belanja = $this->belanja->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->belanja->getEditForm($belanja->id);

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
        $this->belanja->update($belanja, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.',
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        $this->belanja->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

    /**
     * Seting rka Desa
     * jika dalam waktu 7 hari setelah update rka belum disetujui maka secara
     * otomatis status dari rka menjadi dpa
     *
     * @return array
     */
    public function setRKA()
    {
        $id = $this->input("id");
        $this->belanja->setRKA($id);

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
        $belanja = $this->belanja->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->belanja->getHistoryForm();

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->belanja->setHistory($belanja, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];
    }
}