<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 22:18
 */

namespace Perdes;

use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Repositories\Perdes\MateriPokokPoinRepositoryInterface;
use Simdes\Repositories\Perdes\MateriPokokRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class MateriPokokController
 * @package Perdes
 */
class MateriPokokPoinController extends \BaseController
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
     * @var \Simdes\Repositories\Perdes\MateriPokokPoinRepositoryInterface
     */
    protected $poin;

    /**
     * @param UserRepositoryInterface $auth
     * @param JudulRepositoryInterface $judul
     * @param MateriPokokRepositoryInterface $materiPokok
     * @param MateriPokokPoinRepositoryInterface $poin
     */
    public function __construct(
        UserRepositoryInterface $auth,
        JudulRepositoryInterface $judul,
        MateriPokokRepositoryInterface $materiPokok,
        MateriPokokPoinRepositoryInterface $poin
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->judul = $judul;
        $this->materiPokok = $materiPokok;
        $this->poin = $poin;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        if (!Auth::check()) {
            return Redirect::to('login');
        }
        return Redirect::to('data-perdes-judul');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        $materi_pokok_id = $this->input('materi_pokok_id');

        return $this->poin->findAll($term, $this->auth->getOrganisasiId(), $materi_pokok_id);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->poin->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'materi_pokok_id' => $message->first('materi_pokok_id'),
                    'poin'            => $message->first('poin'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->poin->create($data);

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
        return $this->poin->findById($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $poin = $this->poin->findById($id, $this->auth->getOrganisasiId());
        $form = $this->poin->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'poin' => $message->first('poin'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->poin->update($poin, $data);

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
        $data = $this->materiPokok->findById($id, $this->auth->getOrganisasiId());
        if (!$data) {
            return $this->redirectURLTo('data-perdes-judul');
        }

        $this->view('perdes.detail-materi-pokok', [
            'data' => $data,
            'poin' => $data->poin,
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->poin->delete($id, $this->auth->getOrganisasiId());

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

} 