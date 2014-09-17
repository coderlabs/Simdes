<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 22:18
 */

namespace Perdes;

use Simdes\Repositories\Perdes\DasarHukumRepositoryInterface;
use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class DasarHukumController
 * @package Perdes
 */
class DasarHukumController extends \BaseController
{
    /**
     * @var \Simdes\Repositories\Perdes\JudulRepositoryInterface
     */
    protected $judul;
    /**
     * @var \Simdes\Repositories\Perdes\DasarHukumRepositoryInterface
     */
    protected $dasarHukum;

    /**
     * @param UserRepositoryInterface $auth
     * @param DasarHukumRepositoryInterface $dasarHukum
     * @param JudulRepositoryInterface $judul
     */
    public function __construct(
        UserRepositoryInterface $auth,
        DasarHukumRepositoryInterface $dasarHukum,
        JudulRepositoryInterface $judul
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->dasarHukum = $dasarHukum;
        $this->judul = $judul;

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

        return $this->dasarHukum->findAll($term, $this->auth->getOrganisasiId(), $perdes_id);
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->dasarHukum->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'pengundangan' => $message->first('pengundangan'),
                    'dasar_hukum'  => $message->first('dasar_hukum'),
                    'perdes_id'    => $message->first('perdes_id'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->dasarHukum->create($data);

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
        return $this->dasarHukum->findById($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->dasarHukum->findById($id, $this->auth->getOrganisasiId());
        $form = $this->dasarHukum->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'pengundangan' => $message->first('pengundangan'),
                    'dasar_hukum'  => $message->first('dasar_hukum'),
                    'perdes_id'    => $message->first('perdes_id'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->dasarHukum->update($pendapatan, $data);

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
        $this->view('perdes.data-perdes-dasar-hukum', [
            'data' => $data,
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->dasarHukum->delete($id, $this->auth->getOrganisasiId());

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }
} 