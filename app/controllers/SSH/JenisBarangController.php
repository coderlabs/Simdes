<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 19:45
 */

namespace SSH;

use Simdes\Repositories\SSH\JenisBarangRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class JenisBarangController
 *
 * @package controllers\ssh
 */
class JenisBarangController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\SSH\JenisBarangRepositoryInterface
     */
    private $jenisBarang;

    /**
     * @param JenisBarangRepositoryInterface $jenisBarang
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        JenisBarangRepositoryInterface $jenisBarang,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->jenisBarang = $jenisBarang;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->jenisBarang->findAll($term = null);
        $this->view('ssh.data-jenis-barang', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->jenisBarang->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->jenisBarang->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kelompok_id'   => $message->first('kelompok_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'jenis'         => $message->first('jenis')
                ],
            ];
        }
        $data = $form->getInputData();
        $this->jenisBarang->create($data);

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
        $data = $this->jenisBarang->findById($id);

        return [
            'id'            => $data->id,
            'kelas'         => $data->kelompok->kelas_id,
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
        $jenisBarang = $this->jenisBarang->findById($id);
        $form = $this->jenisBarang->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kelompok_id'   => $message->first('kelompok_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'jenis'         => $message->first('jenis')
                ]
            ];
        }

        $data = $form->getInputData();
        $this->jenisBarang->update($jenisBarang, $data);

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
        return $this->jenisBarang->delete($id);
    }

}