<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/18/2014
 * Time: 14:58
 */

namespace RKPDesa;

use Simdes\Repositories\RKPDesa\IndikatorManfaatRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class IndikatorManfaatController
 *
 * @package RKPDesa
 */
class IndikatorManfaatController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\RKPDesa\IndikatorManfaatRepositoryInterface
     */
    private $manfaat;

    /**
     * @param UserRepositoryInterface $auth
     * @param IndikatorManfaatRepositoryInterface $manfaat
     */
    public function __construct(
        UserRepositoryInterface $auth,
        IndikatorManfaatRepositoryInterface $manfaat
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->manfaat = $manfaat;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->manfaat->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rkpdesa');
        } else {
            $this->view('indikator.indikator-manfaat', [
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
        $manfaat = $this->manfaat->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->manfaat->getEditForm();

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
        $this->manfaat->update($manfaat, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }

}