<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 18/09/2014
 * Time: 7:40
 */

namespace Organisasi;


use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class OrganisasiController
 * @package Organisasi
 */
class OrganisasiController extends \BaseController
{
    /**
     * @var OrganisasiRepositoryInterface
     */
    protected $organisasi;

    /**
     * @param OrganisasiRepositoryInterface $organisasi
     */
    public function __construct(
        OrganisasiRepositoryInterface $organisasi,
        UserRepositoryInterface $auth
    )
    {
        parent::__construct();
        $this->organisasi = $organisasi;
        $this->auth = $auth;
    }


    /**
     * @return \View
     */
    public function index()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $this->view('organisasi.organisasi', ['organisasi' => $organisasi]);
    }

    /**
     * Update organsiasi
     */
    public function update()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        $form = $this->organisasi->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'nama'      => $message->first('nama'),
                    'alamat'    => $message->first('alamat'),
                    'desa'      => $message->first('desa'),
                    'kode_kec'  => $message->first('kode_kec'),
                    'kode_kab'  => $message->first('kode_kab'),
                    'kode_prov' => $message->first('kode_prov'),
                    'no_telp'   => $message->first('no_telp'),
                    'email'     => $message->first('email'),
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        return $this->organisasi->update($organisasi, $data);

    }

    /**
     * menampilkan detail Organsiasi
     *
     * return \View
     */
    public function show()
    {
        $data = $this->organisasi->getKode($this->auth->getKabIdByOrganisasiId());
        $this->view('organisasi.detil-organisasi', ['data' => $data]);
    }

} 