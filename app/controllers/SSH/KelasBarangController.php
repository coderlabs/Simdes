<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 18:27
 */

namespace SSH;

use Simdes\Repositories\SSH\KelasBarangRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KelasBarangController
 *
 * @package ssh
 */
class KelasBarangController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\SSH\KelasBarangRepositoryInterface
     */
    private $kelasBarang;

    /**
     * @param KelasBarangRepositoryInterface $kelasBarang
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        KelasBarangRepositoryInterface $kelasBarang,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->kelasBarang = $kelasBarang;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->kelasBarang->findAll($term = null);
        $this->view('ssh.data-kelas-barang', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        return $this->kelasBarang->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->kelasBarang->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kelas'         => $message->first('kelas')
                ],
            ];
        }
        $data = $form->getInputData();
        $this->kelasBarang->create($data);

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
        return $this->kelasBarang->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $kelasBarang = $this->kelasBarang->findById($id);
        $form = $this->kelasBarang->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kelas'         => $message->first('kelas')
                ]
            ];
        }

        $data = $form->getInputData();
        $this->kelasBarang->update($kelasBarang, $data);

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
        return $this->kelasBarang->delete($id);
    }
}