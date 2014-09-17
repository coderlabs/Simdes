<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/29/2014
 * Time: 13:30
 */

namespace Kewenangan;

use Simdes\Repositories\Kewenangan\KewenanganRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KewenanganController
 * @package Kewenangan
 */
class KewenanganController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Kewenangan\KewenanganRepositoryInterface
     */
    protected $kewenangan;

    /**
     * @param UserRepositoryInterface $auth
     * @param KewenanganRepositoryInterface $kewenangan
     */
    public function __construct(
        UserRepositoryInterface $auth,
        KewenanganRepositoryInterface $kewenangan
    )
    {
        parent::__construct();
        $this->auth = $auth;
        $this->kewenangan = $kewenangan;
    }

    /**
     * Menampilkan list kewenangan
     */
    public function index()
    {
        $data = $this->kewenangan->findAll($term = null);
        $this->view('kewenangan.data-kewenangan', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        return $this->kewenangan->findAll($term);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->kewenangan->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kewenangan'    => $message->first('kewenangan'),
                ],
            ];

        }

        $data = $form->getInputData();
        $this->kewenangan->create($data);

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
        return $this->kewenangan->findById($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $kewenangan = $this->kewenangan->findById($id);
        $form = $this->kewenangan->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'kode_rekening' => $message->first('kode_rekening'),
                    'kewenangan'    => $message->first('kewenangan'),
                ],
            ];
        }

        $data = $form->getInputData();
        $this->kewenangan->update($kewenangan, $data);

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
        return $this->kewenangan->delete($id);

    }
}