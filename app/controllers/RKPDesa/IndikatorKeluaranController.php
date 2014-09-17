<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/18/2014
 * Time: 13:01
 */

namespace RKPDesa;

use Simdes\Repositories\RKPDesa\IndikatorKeluaranRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class IndikatorKeluaranController
 *
 * @package RKPDesa
 */
class IndikatorKeluaranController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\RKPDesa\IndikatorKeluaranRepositoryInterface
     */
    private $keluaran;

    /**
     * @param IndikatorKeluaranRepositoryInterface $keluaran
     * @param UserRepositoryInterface $auth
     */
    public function __construct(
        IndikatorKeluaranRepositoryInterface $keluaran,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->keluaran = $keluaran;
        $this->auth = $auth;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->keluaran->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rkpdesa');
        } else {
            $this->view('indikator.indikator-keluaran', [
                'data' => $data
            ]);
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $keluaran = $this->keluaran->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->keluaran->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'tolok_ukur' => $message->first('tolok_ukur'),
                    'target'     => $message->first('target'),
                    'satuan'     => $message->first('satuan')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->keluaran->update($keluaran, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }

}