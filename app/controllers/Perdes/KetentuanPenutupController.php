<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 22:18
 */

namespace Perdes;

use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Repositories\Perdes\KetentuanPenutupRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class KetentuanPenutupController
 * @package Perdes
 */
class KetentuanPenutupController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Perdes\JudulRepositoryInterface
     */
    protected $judul;
    /**
     * @var \Simdes\Repositories\Perdes\KetentuanPenutupRepositoryInterface
     */
    protected $ketentuanPenutup;

    /**
     * @param UserRepositoryInterface $auth
     * @param JudulRepositoryInterface $judul
     * @param KetentuanPenutupRepositoryInterface $ketentuanPenutup
     */
    public function __construct(
        UserRepositoryInterface $auth,
        JudulRepositoryInterface $judul,
        KetentuanPenutupRepositoryInterface $ketentuanPenutup
    )
    {
        $this->beforeFilter('auth.post', ['on' => 'post']);
        $this->beforeFilter('csrf', ['on' => 'post']);

        $this->auth = $auth;
        $this->judul = $judul;
        $this->ketentuanPenutup = $ketentuanPenutup;
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

        return $this->ketentuanPenutup->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->ketentuanPenutup->getCreationForm();

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
        $this->ketentuanPenutup->create($data);

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
        return $this->ketentuanPenutup->findById($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->ketentuanPenutup->findById($id, $this->auth->getOrganisasiId());
        $form = $this->ketentuanPenutup->getEditForm();

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
        $this->ketentuanPenutup->update($pendapatan, $data);

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
        $this->ketentuanPenutup->delete($id, $this->auth->getOrganisasiId());

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

} 