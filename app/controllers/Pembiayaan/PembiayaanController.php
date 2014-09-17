<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 20:17
 */

namespace Pembiayaan;

use Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class PembiayaanController
 *
 * @package controllers\Pembiayaan
 */
class PembiayaanController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface
     */
    private $pembiayaan;

    /**
     * @param PembiayaanRepositoryInterface $pembiayaan
     * @param UserRepositoryInterface $auth
     */
    function __construct(
        PembiayaanRepositoryInterface $pembiayaan,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->pembiayaan = $pembiayaan;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->view('pembiayaan.data-pembiayaan');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->pembiayaan->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->pembiayaan->getCreationForm();

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
        $this->pembiayaan->create($data);

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
    public function edit($id)
    {
        return $this->pembiayaan->findByFilter($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $pembiayaan = $this->pembiayaan->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->pembiayaan->getEditForm($pembiayaan->id);

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
        $this->pembiayaan->update($pembiayaan, $data);

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
        $this->pembiayaan->delete($id);

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
        $this->pembiayaan->setRKA($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : rka Desa sudah diseting.',
        ];
    }
}