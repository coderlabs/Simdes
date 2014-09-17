<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 18:38
 */

namespace SSH;

use Simdes\Repositories\SSH\KelompokBarangRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KelompokBarangController
 *
 * @package ssh
 */
class KelompokBarangController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\SSH\KelompokBarangRepositoryInterface
     */
    private $kelompokBarang;

    /**
     * @param KelompokBarangRepositoryInterface $kelompokBarang
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        KelompokBarangRepositoryInterface $kelompokBarang,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->kelompokBarang = $kelompokBarang;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->kelompokBarang->findAll($term = null);
        $this->view('ssh.data-kelompok-barang', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->kelompokBarang->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->kelompokBarang->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kelas_id'      => $message->first('kelas_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kelompok'      => $message->first('kelompok')
                ],
            ];
        }
        $data = $form->getInputData();
        $this->kelompokBarang->create($data);

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
        $data = $this->kelompokBarang->findById($id);

        return [
            'id'            => $data->id,
            'kelas_id'      => $data->kelas_id,
            'kelas'         => $data->kelas_id . '|' . $data->kelas->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'kelompok'      => $data->kelompok,
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $kelompokBarang = $this->kelompokBarang->findById($id);
        $form = $this->kelompokBarang->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kelas_id'      => $message->first('kelas_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kelompok'      => $message->first('kelompok')
                ]
            ];
        }

        $data = $form->getInputData();
        $this->kelompokBarang->update($kelompokBarang, $data);

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
        return $this->kelompokBarang->delete($id);
    }

}