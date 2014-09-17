<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 22:18
 */

namespace Perdes;

use Simdes\Repositories\Perdes\BatangTubuhRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class BatangTubuhController
 * @package Perdes
 */
class BatangTubuhController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Perdes\BatangTubuhRepositoryInterface
     */
    protected $batangTubuh;


    /**
     * @param UserRepositoryInterface $auth
     * @param BatangTubuhRepositoryInterface $batangTubuh
     */
    public function __construct(
        UserRepositoryInterface $auth,
        BatangTubuhRepositoryInterface $batangTubuh
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->batangTubuh = $batangTubuh;

    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->view('perdes.data-perdes-batang-tubuh');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->batangTubuh->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->batangTubuh->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'istilah'   => $message->first('istilah'),
                    'perdes_id' => $message->first('perdes_id`'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->batangTubuh->create($data);

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
        return $this->batangTubuh->findById($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->batangTubuh->findById($id, $this->auth->getOrganisasiId());
        $form = $this->batangTubuh->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'istilah'   => $message->first('istilah'),
                    'perdes_id' => $message->first('perdes_id`'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->batangTubuh->update($pendapatan, $data);

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
        return $this->redirectURLTo('data-perdes-batang-tubuh');
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->batangTubuh->delete($id, $this->auth->getOrganisasiId());

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }

} 