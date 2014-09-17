<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 19:57
 */

namespace SSH;

use Simdes\Repositories\SSH\RincianObyekBarangRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class RincianObyekBarangController
 *
 * @package ssh
 */
class SshBarangController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\SSH\RincianObyekBarangRepositoryInterface
     */
    private $rincianBarang;

    /**
     * @param RincianObyekBarangRepositoryInterface $rincianBarang
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        RincianObyekBarangRepositoryInterface $rincianBarang,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->rincianBarang = $rincianBarang;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->rincianBarang->findAll($term = null);
        $this->view('ssh.standar-satuan-harga', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->rincianBarang->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->rincianBarang->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_barang'     => $message->first('kode_barang'),
                    'obyek_barang_id' => $message->first('obyek_barang_id'),
                    'rincian_obyek'   => $message->first('rincian_obyek'),
                    'spesifikasi'     => $message->first('spesifikasi'),
                    'satuan'          => $message->first('satuan'),
                    'harga'           => $message->first('harga')
                ],
            ];
        }
        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->rincianBarang->create($data);

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
        return $this->rincianBarang->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $rincianBarang = $this->rincianBarang->findById($id);
        $form = $this->rincianBarang->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_barang'     => $message->first('kode_barang'),
                    'obyek_barang_id' => $message->first('obyek_barang_id'),
                    'rincian_obyek'   => $message->first('rincian_obyek'),
                    'spesifikasi'     => $message->first('spesifikasi'),
                    'satuan'          => $message->first('satuan'),
                    'harga'           => $message->first('harga')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->rincianBarang->update($rincianBarang, $data);

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
        $this->rincianBarang->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }

}