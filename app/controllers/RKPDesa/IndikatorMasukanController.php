<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/18/2014
 * Time: 13:12
 */

namespace RKPDesa;

use Simdes\Repositories\RKPDesa\IndikatorMasukanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class IndikatorMasukanController
 *
 * @package RKPDesa
 */
class IndikatorMasukanController extends \BaseController
{


    /**
     * @var \Simdes\Repositories\RKPDesa\IndikatorMasukanRepositoryInterface
     */
    private $masukan;

    /**
     * @param IndikatorMasukanRepositoryInterface $masukan
     * @param UserRepositoryInterface $auth
     */
    function __construct(
        IndikatorMasukanRepositoryInterface $masukan,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->masukan = $masukan;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->masukan->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rkpdesa');
        } else {
            $this->view('indikator.indikator-masukan', [
                'data' => $data
            ]);
        }
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $masukan = $this->masukan->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->masukan->getEditForm();

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
        $this->masukan->update($masukan, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }


}