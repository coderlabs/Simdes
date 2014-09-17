<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 14:06
 */

namespace RPJMDesa;

use Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface;
use Simdes\Repositories\RPJMDesa\PotensiRepositoryInterface;
use Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class PotensiController
 *
 * @package RPJMDesa
 */
class PotensiController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\RPJMDesa\PotensiRepositoryInterface
     */
    private $potensi;
    /**
     * @var \Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface
     */
    private $RPJMDesa;

    /**
     * @var \Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface
     */
    private $masalah;

    /**
     * @param PotensiRepositoryInterface $potensi
     * @param RPJMDesaRepositoryInterface $RPJMdesa
     * @param MasalahRepositoryInterface $masalah
     * @param UserRepositoryInterface $auth
     */
    function __construct(
        PotensiRepositoryInterface $potensi,
        RPJMDesaRepositoryInterface $RPJMdesa,
        MasalahRepositoryInterface $masalah,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->potensi = $potensi;
        $this->RPJMDesa = $RPJMdesa;
        $this->masalah = $masalah;
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->redirectURLTo('rpjmdesa.data-rpjmdesa');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->masalah->findByFilter($id, $this->auth->getOrganisasiId());

        if ($data == null) {
            return $this->redirectURLTo('rpjmdesa.data-rpjmdesa');
        } else {
            $this->view('rpjmdesa.data-potensi', compact('data'));
        }
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        $masalah_id = $this->input('masalah_id');

        return $this->potensi->findAll($term, $masalah_id, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->potensi->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'potensi'    => $message->first('potensi'),
                    'masalah_id' => $message->first('masalah_id')
                ],
            ];

        }
        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->potensi->create($data);

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
        return $this->potensi->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $potensi = $this->potensi->findById($id);
        $form = $this->potensi->getEditForm();

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
        $this->potensi->update($potensi, $data);

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
        $this->potensi->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }
}