<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/9/2014
 * Time: 09:00
 */

namespace Transaksi;

use Simdes\Repositories\Transaksi\BelanjaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class BelanjaController
 * @package Transaksi
 */
class BelanjaController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Transaksi\BelanjaRepositoryInterface
     */
    protected $belanja;
    /**
     * @var \Simdes\Repositories\Belanja\BelanjaRepositoryInterface
     */
    protected $anggaran;

    /**
     * @param BelanjaRepositoryInterface $belanja
     * @param UserRepositoryInterface $auth
     * @param \Simdes\Repositories\Belanja\BelanjaRepositoryInterface $anggaran
     */
    public function __construct(
        BelanjaRepositoryInterface $belanja,
        UserRepositoryInterface $auth,
        \Simdes\Repositories\Belanja\BelanjaRepositoryInterface $anggaran
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->belanja = $belanja;
        $this->anggaran = $anggaran;
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
                    'belanja_id'      => $message->first('belanja_id'),
                    'no_bukti'        => $message->first('no_bukti'),
                    'tanggal'         => $message->first('tanggal'),
                    'pejabat_desa_id' => $message->first('pejabat_desa_id'),
                    'jumlah'          => $message->first('jumlah'),
                    'ssh_id'          => $message->first('ssh_id'),
                    'kode_barang'     => $message->first('kode_barang'),
                    'penerima'        => $message->first('penerima'),
                    'item'            => $message->first('item'),
                    'harga'           => $message->first('harga'),
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
     * tidak ada data detail
     * kembalikan ke index
     */
    public function show()
    {
        return $this->index();
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->view('transaksi.belanja');
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->belanja->findById($id);
        $form = $this->belanja->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'belanja_id'      => $message->first('belanja_id'),
                    'no_bukti'        => $message->first('no_bukti'),
                    'tanggal'         => $message->first('tanggal'),
                    'pejabat_desa_id' => $message->first('pejabat_desa_id'),
                    'jumlah'          => $message->first('jumlah'),
                    'ssh_id'          => $message->first('ssh_id'),
                    'kode_barang'     => $message->first('kode_barang'),
                    'penerima'        => $message->first('penerima'),
                    'item'            => $message->first('item'),
                    'harga'           => $message->first('harga'),
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->belanja->update($pendapatan, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function edit($id)
    {
        $data = $this->belanja->findById($id);

        return [
            'id'              => $data->id,
            'belanja_id'      => $data->belanja_id,
            'kegiatan'        => $data->kegiatan,
            'barang'          => $data->uraian,
            'harga'           => $data->harga,
            'item'            => $data->item,
            'ssh_id'          => $data->ssh_id,
            'kode_barang'     => $data->kode_barang,
            'realisasi'       => $data->belanja->realisasi,
            'no_bukti'        => $data->no_bukti,
            'tanggal'         => $data->tanggal,
            'pejabat_desa_id' => $data->pejabat_desa_id,
            'uraian'          => $data->uraian,
            'jumlah'          => $data->jumlah,
        ];
    }

    public function posting()
    {
        $id = $this->input('id');
        $belanja = $this->belanja->findById($id);

        $this->belanja->posting($belanja);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data transaksi belanja sudah diposting.'
        ];

    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->belanja->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }

} 