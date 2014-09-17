<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 19:52
 */

namespace SSH;

use Simdes\Repositories\SSH\ObyekBarangRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class ObyekBarangController
 *
 * @package controllers\ssh
 */
class ObyekBarangController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\SSH\ObyekBarangRepositoryInterface
     */
    private $obyekBarang;

    /**
     * @param ObyekBarangRepositoryInterface $obyekBarang
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        ObyekBarangRepositoryInterface $obyekBarang,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->obyekBarang = $obyekBarang;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->obyekBarang->findAll($term = null);
        $this->view('ssh.data-obyek-barang', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->obyekBarang->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->obyekBarang->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'jenis_id'      => $message->first('jenis_id'),
                    'obyek'         => $message->first('obyek')
                ],
            ];
        }
        $data = $form->getInputData();
        $this->obyekBarang->create($data);

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
        $data = $this->obyekBarang->findById($id);

        return [
            'id'            => $data->id,
            'kelas'         => $data->jenis->kelompok->kelas_id,
            'kelompok'      => $data->jenis->kelompok_id,
            'jenis'         => $data->jenis_id . '|' . $data->jenis->kode_rekening,
            'jenis_id'      => $data->jenis_id,
            'kode_rekening' => $data->kode_rekening,
            'obyek'         => $data->obyek,
        ];

    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $obyekBarang = $this->obyekBarang->findById($id);
        $form = $this->obyekBarang->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'jenis_id'      => $message->first('jenis_id'),
                    'obyek'         => $message->first('obyek')
                ]
            ];
        }

        $data = $form->getInputData();
        $this->obyekBarang->update($obyekBarang, $data);

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
        return $this->obyekBarang->delete($id);
    }

}