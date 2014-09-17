<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:58
 */

namespace RPJMDesa;

use Illuminate\Support\Facades\Redirect;
use Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface;
use Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface;
use Simdes\Repositories\RPJMDesa\VisiRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class RPJMDesaController
 *
 * @package RPJMDesa
 */
class RPJMDesaController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\RPJMDesa\VisiRepositoryInterface
     */
    private $visi;

    /**
     * @var
     */
    private $RPJMDesa;

    /**
     * @var
     */
    private $masalah;

    /**
     * @param VisiRepositoryInterface $visi
     * @param RPJMDesaRepositoryInterface $RPJMDesa
     * @param MasalahRepositoryInterface $masalah
     * @param UserRepositoryInterface $auth
     */
    function __construct(
        VisiRepositoryInterface $visi,
        RPJMDesaRepositoryInterface $RPJMDesa,
        MasalahRepositoryInterface $masalah,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->visi = $visi;
        $this->RPJMDesa = $RPJMDesa;
        $this->masalah = $masalah;
        $this->auth = $auth;

    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->visi->findAll($term = null, $this->auth->getOrganisasiId());
        $this->view('rpjmdesa.data-rpjmdesa', compact('data'));
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        return $this->visi->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->visi->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return $response = [
                'Status'     => 'Validation',
                'validation' => [
                    'visi' => $message->first('visi')
                ],
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->visi->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.'
        ];

    }

    /**
     * @param $id
     *
     * @return array
     */
    public function edit($id)
    {
        return $this->visi->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $visi = $this->visi->findById($id);
        $form = $this->visi->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'visi' => $message->first('visi')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->visi->update($visi, $data);

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
        return $this->visi->delete($id);
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $data = $this->RPJMDesa->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rpjmdesa');
        } else {
            $data_masalah = $this->RPJMDesa->findMasalah($id);
            $data_misi = $this->RPJMDesa->findMisi($id);
            $no_misi = 1;
            $no_masalah = 1;

            $this->view('rpjmdesa.detail-rpjmdesa', [
                'data'         => $data,
                'data_masalah' => $data_masalah,
                'data_misi'    => $data_misi,
                'no_misi'      => $no_misi,
                'no_masalah'   => $no_masalah
            ]);
        }
    }
}