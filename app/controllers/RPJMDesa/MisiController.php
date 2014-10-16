<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 08:00
 */

namespace RPJMDesa;

use Simdes\Repositories\RPJMDesa\MisiRepositoryInterface;
use Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class MisiController
 *
 * @package RPJMDesa
 */
class MisiController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\RPJMDesa\MisiRepositoryInterface
     */
    private $misi;
    /**
     * @var \Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface
     */
    private $RPJMDesa;

    /**
     * @param MisiRepositoryInterface     $misi
     * @param RPJMDesaRepositoryInterface $RPJMDesa
     * @param UserRepositoryInterface     $auth
     */
    function __construct(
        MisiRepositoryInterface $misi,
        RPJMDesaRepositoryInterface $RPJMDesa,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->misi = $misi;
        $this->RPJMDesa = $RPJMDesa;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->redirectURLTo('data-rpjmdesa');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->RPJMDesa->findByFilter($id, $this->auth->getOrganisasiId());
        $result = $this->misi->findAll($term = null, $id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rpjmdesa');
        } else {
            $this->view('rpjmdesa.data-misi', compact('data', 'result'));
        }
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        $rpjmdesa_id = $this->input('rpjmdesa_id');

        return $this->misi->findAll($term, $rpjmdesa_id, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->misi->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'misi' => $message->first('misi')
                ],
            ];

        }
        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->misi->create($data);

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
        return $this->misi->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $misi = $this->misi->findById($id);
        $form = $this->misi->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'misi' => $message->first('misi')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->misi->update($misi, $data);

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
        $this->misi->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }
}