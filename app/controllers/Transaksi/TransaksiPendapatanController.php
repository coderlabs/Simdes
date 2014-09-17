<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/7/2014
 * Time: 08:25
 */

namespace Transaksi;

use Simdes\Repositories\Transaksi\PendapatanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class TransaksiPendapatanController
 * @package Transaksi
 */
class TransaksiPendapatanController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Transaksi\PendapatanRepositoryInterface
     */
    protected $pendapatan;

    /**
     * @var \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface
     */
    protected $anggaran;

    /**
     * @param PendapatanRepositoryInterface $pendapatan
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        PendapatanRepositoryInterface $pendapatan,
        UserRepositoryInterface $auth,
        \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface $anggaran
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->pendapatan = $pendapatan;
        $this->anggaran = $anggaran;
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

            return $response = [
                'Status'     => 'Validation',
                'validation' => [
                    'pendapatan_id'   => $message->first('pendapatan_id'),
                    'no_bukti'        => $message->first('no_bukti'),
                    'tanggal'         => $message->first('tanggal'),
                    'pejabat_desa_id' => $message->first('pejabat_desa_id'),
                    'jumlah'          => $message->first('jumlah'),
                    'uraian'          => $message->first('uraian')
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
        $this->view('transaksi.pendapatan');
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->pendapatan->findById($id);
        $form = $this->pendapatan->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'pendapatan_id'   => $message->first('pendapatan_id'),
                    'no_bukti'        => $message->first('no_bukti'),
                    'tanggal'         => $message->first('tanggal'),
                    'pejabat_desa_id' => $message->first('pejabat_desa_id'),
                    'jumlah'          => $message->first('jumlah'),
                    'uraian'          => $message->first('uraian')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->pendapatan->update($pendapatan, $data);

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
        $data = $this->pendapatan->findById($id);

        return [
            'id'              => $data->id,
            'pendapatan_id'   => $data->pendapatan_id,
            'pendapatan'      => $data->uraian,
            'realisasi'       => $data->pendapatan->realisasi,
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
        $pendapatan = $this->pendapatan->findById($id);

        $this->pendapatan->posting($pendapatan);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data transaksi pendapatan sudah diposting.'
        ];

    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->pendapatan->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }
}