<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/29/2014
 * Time: 13:30
 */

namespace Kewenangan;

use Simdes\Repositories\Kewenangan\BidangRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KewenanganController
 * @package Kewenangan
 */
class BidangController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Kewenangan\BidangRepositoryInterface
     */
    protected $bidang;

    /**
     * @param UserRepositoryInterface $auth
     * @param BidangRepositoryInterface $bidang
     */
    public function __construct(
        UserRepositoryInterface $auth,
        BidangRepositoryInterface $bidang
    )
    {
        parent::__construct();
        $this->auth = $auth;
        $this->bidang = $bidang;
    }

    /**
     * Menampilkan list bidang
     */
    public function index()
    {
        $data = $this->bidang->findAll($term = null);
        $this->view('kewenangan.data-bidang', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->bidang->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->bidang->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'fungsi_id'     => $message->first('fungsi_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'bidang'        => $message->first('bidang'),
                    'regulasi'      => $message->first('regulasi'),
                    'tanggal'       => $message->first('tanggal'),
                    'pengundangan'  => $message->first('pengundangan'),
                ],
            ];

        }

        $data = $form->getInputData();
        $this->bidang->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];

    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $data = $this->bidang->findById($id);

        return [
            'id'            => $data->id,
            'fungsi_id'     => $data->fungsi_id,
            'fungsi'        => $data->fungsi_id . '|' . $data->fungsi->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'jenis'         => $data->jenis,
            'bidang'        => $data->bidang,
            'regulasi'      => $data->regulasi,
            'pengundangan'  => $data->pengundangan,
            'tanggal'       => $data->tanggal,
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $bidang = $this->bidang->findById($id);
        $form = $this->bidang->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'fungsi_id'     => $message->first('fungsi_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'bidang'        => $message->first('bidang'),
                    'regulasi'      => $message->first('regulasi'),
                    'tanggal'       => $message->first('tanggal'),
                    'pengundangan'  => $message->first('pengundangan'),
                ],
            ];
        }

        $data = $form->getInputData();
        $this->bidang->update($bidang, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.',
        ];

    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->bidang->delete($id);
    }
}