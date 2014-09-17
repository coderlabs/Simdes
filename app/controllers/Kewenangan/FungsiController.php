<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/29/2014
 * Time: 13:30
 */

namespace Kewenangan;

use Simdes\Repositories\Kewenangan\FungsiRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KewenanganController
 * @package Kewenangan
 */
class FungsiController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Kewenangan\fungsiRepositoryInterface
     */
    protected $fungsi;

    /**
     * @param UserRepositoryInterface $auth
     * @param FungsiRepositoryInterface $fungsi
     */
    public function __construct(
        UserRepositoryInterface $auth,
        FungsiRepositoryInterface $fungsi
    )
    {
        parent::__construct();
        $this->auth = $auth;
        $this->fungsi = $fungsi;
    }

    /**
     * Menampilkan list fungsi
     */
    public function index()
    {
        $data = $this->fungsi->findAll($term = null);
        $this->view('kewenangan.data-fungsi', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->fungsi->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->fungsi->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kewenangan_id' => $message->first('kewenangan_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'fungsi'        => $message->first('fungsi'),
                ],
            ];

        }

        $data = $form->getInputData();
        $this->fungsi->create($data);

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
        $data = $this->fungsi->findById($id);

        return [
            'id'            => $data->id,
            'kewenangan_id' => $data->kewenangan_id,
            'kewenangan'    => $data->kewenangan_id . '|' . $data->kewenangan->kode_rekening,
            'kode_rekening' => $data->kode_rekening,
            'fungsi'        => $data->fungsi,
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $fungsi = $this->fungsi->findById($id);
        $form = $this->fungsi->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kewenangan_id' => $message->first('kewenangan_id'),
                    'kode_rekening' => $message->first('kode_rekening'),
                    'fungsi'        => $message->first('fungsi'),
                ],
            ];
        }

        $data = $form->getInputData();
        $this->fungsi->update($fungsi, $data);

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
        return $this->fungsi->delete($id);
    }
}