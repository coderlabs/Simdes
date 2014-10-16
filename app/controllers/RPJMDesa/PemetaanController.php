<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 17:30
 */

namespace RPJMDesa;

use Simdes\Repositories\RPJMDesa\PemetaanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class PemetaanController
 *
 * @package RPJMDesa
 */
class PemetaanController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\RPJMDesa\PemetaanRepositoryInterface
     */
    private $pemetaan;

    /**
     * @param PemetaanRepositoryInterface $pemetaan
     * @param UserRepositoryInterface     $auth
     */
    function __construct(
        PemetaanRepositoryInterface $pemetaan,
        UserRepositoryInterface $auth

    )
    {
        parent::__construct();

        $this->pemetaan = $pemetaan;
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
        $data = $this->pemetaan->findByFilter($id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rpjmdesa');
        } else {
            $this->view('rpjmdesa.data-pemetaan', compact('data'));
        }
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $pemetaan = $this->pemetaan->findById($id);
        $form = $this->pemetaan->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'pemetaan_1' => $message->first('pemetaan_1'),
                    'pemetaan_2' => $message->first('pemetaan_2'),
                    'pemetaan_3' => $message->first('pemetaan_3'),
                    'pemetaan_4' => $message->first('pemetaan_4'),
                    'pemetaan_5' => $message->first('pemetaan_5')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->pemetaan->update($pemetaan, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }
}