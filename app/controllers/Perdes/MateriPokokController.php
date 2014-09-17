<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 22:18
 */

namespace Perdes;

use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Repositories\Perdes\MateriPokokRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class MateriPokokController
 * @package Perdes
 */
class MateriPokokController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Perdes\JudulRepositoryInterface
     */
    protected $judul;

    /**
     * @var \Simdes\Repositories\Perdes\MateriPokokRepositoryInterface
     */
    protected $materiPokok;

    /**
     * @param UserRepositoryInterface $auth
     * @param JudulRepositoryInterface $judul
     * @param MateriPokokRepositoryInterface $materiPokok
     */
    public function __construct(
        UserRepositoryInterface $auth,
        JudulRepositoryInterface $judul,
        MateriPokokRepositoryInterface $materiPokok
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->judul = $judul;
        $this->materiPokok = $materiPokok;
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
        $perdes_id = $this->input('perdes_id');

        return $this->materiPokok->findAll($term, $this->auth->getOrganisasiId(), $perdes_id);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->materiPokok->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'perdes_id' => $message->first('perdes_id'),
                    'judul'     => $message->first('judul'),
                    'bab'       => $message->first('bab'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->materiPokok->create($data);

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
        return $this->materiPokok->findById($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->materiPokok->findById($id, $this->auth->getOrganisasiId());
        $form = $this->materiPokok->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'perdes_id' => $message->first('perdes_id'),
                    'judul'     => $message->first('judul'),
                    'bab'       => $message->first('bab'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->materiPokok->update($pendapatan, $data);

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

        $this->view('perdes.data-perdes-materi-pokok', [
            'data' => $data,
        ]);
    }

    /**
     * @param $id
     */
    public function poin($id)
    {
        $data = $this->materiPokok->findById($id, $this->auth->getOrganisasiId());

        if (!$data) {
            return $this->redirectURLTo('data-perdes-judul');
        }

        $this->view('perdes.detail-materi-pokok', [
            'data'       => $data,
            'poin'       => $data->poin,
            'count_poin' => count($data->poin)
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->materiPokok->delete($id, $this->auth->getOrganisasiId());

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

} 