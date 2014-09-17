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
class RincianObyekBarangController extends \BaseController
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
        $this->view('ssh.data-rincian-obyek-barang', compact('data'));
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
                    'kode_rekening' => $message->first('kode_rekening'),
                    'obyek_id'      => $message->first('obyek_id'),
                    'rincian_obyek' => $message->first('rincian_obyek'),
                    'spesifikasi'   => $message->first('spesifikasi'),
                    'harga'         => $message->first('harga'),
                    'satuan'        => $message->first('satuan')
                ],
            ];
        }
        $data = $form->getInputData();
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
        $data = $this->rincianBarang->findById($id);

        return [
            'id'            => $data->id,
            'kelas'         => $data->obyek->jenis->kelompok->kelas_id,
            'kelompok'      => $data->obyek->jenis->kelompok_id,
            'jenis'         => $data->obyek->jenis_id,
            'obyek'         => $data->obyek_id . '|' . $data->obyek->kode_rekening,
            'obyek_id'      => $data->obyek_id,
            'kode_rekening' => $data->kode_rekening,
            'spesifikasi'   => $data->spesifikasi,
            'rincian_obyek' => $data->rincian_obyek,
            'harga'         => $data->harga,
            'satuan'        => $data->satuan,
        ];

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
                    'kode_rekening' => $message->first('kode_rekening'),
                    'obyek_id'      => $message->first('obyek_id'),
                    'rincian_obyek' => $message->first('rincian_obyek'),
                    'spesifikasi'   => $message->first('spesifikasi'),
                    'harga'         => $message->first('harga'),
                    'satuan'        => $message->first('satuan')
                ]
            ];
        }

        $data = $form->getInputData();
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