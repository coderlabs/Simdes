<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/18/2014
 * Time: 14:45
 */

namespace RKPDesa;

use Simdes\Repositories\RKPDesa\IndikatorHasilRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class IndikatorHasilController
 *
 * @package controllers\RKPDesa
 */
class IndikatorHasilController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\RKPDesa\IndikatorHasilRepositoryInterface
     */
    private $hasil;

    /**
     * @param UserRepositoryInterface $auth
     * @param IndikatorHasilRepositoryInterface $hasil
     */
    function __construct(
        UserRepositoryInterface $auth,
        IndikatorHasilRepositoryInterface $hasil
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->hasil = $hasil;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->hasil->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rkpdesa');
        } else {
            $this->view('indikator.indikator-hasil', [
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
        $hasil = $this->hasil->findByFilter($id, $this->auth->getOrganisasiId());
        $form = $this->hasil->getEditForm();

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
        $this->hasil->update($hasil, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }

}