<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 22:18
 */

namespace Perdes;

use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Repositories\Perdes\KetentuanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KetentuanController
 * @package Perdes
 */
class KetentuanController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Perdes\JudulRepositoryInterface
     */
    protected $judul;
    /**
     * @var \Simdes\Repositories\Perdes\KetentuanRepositoryInterface
     */
    protected $ketentuan;

    /**
     * @param UserRepositoryInterface $auth
     * @param JudulRepositoryInterface $judul
     * @param KetentuanRepositoryInterface $ketentuan
     */
    public function __construct(
        UserRepositoryInterface $auth,
        JudulRepositoryInterface $judul,
        KetentuanRepositoryInterface $ketentuan
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->judul = $judul;
        $this->ketentuan = $ketentuan;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->redirectURLTo('data-perdes-judul');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->ketentuan->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->ketentuan->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'perdes_id'   => $message->first('perdes_id'),
                    'judul'       => $message->first('judul'),
                    'pasal'       => $message->first('pasal'),
                    'pendahuluan' => $message->first('pendahuluan'),
                    'poin'        => $message->first('poin'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->ketentuan->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function edit($id)
    {
        return $this->ketentuan->findById($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->ketentuan->findById($id, $this->auth->getOrganisasiId());
        $form = $this->ketentuan->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'judul'       => $message->first('judul'),
                    'pasal'       => $message->first('pasal'),
                    'pendahuluan' => $message->first('pendahuluan'),
                    'poin'        => $message->first('poin'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->ketentuan->update($pendapatan, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.',
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->judul->findById($id, $this->auth->getOrganisasiId());

        if (!$data) {
            return $this->redirectURLTo('data-perdes-judul');
        }
        $this->view('perdes.data-ketentuan', [
            'data' => $data,
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->ketentuan->delete($id, $this->auth->getOrganisasiId());

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

} 