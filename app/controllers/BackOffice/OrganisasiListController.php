<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 18/09/2014
 * Time: 7:40
 */

namespace BackOffice;


use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class OrganisasiController
 * @package Organisasi
 */
class OrganisasiListController extends \BaseController
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
     *
     */
    public function index()
    {
        $data = $this->organisasi->getListByKabId($term = null, $this->auth->getKabIdByOrganisasiId());

        $this->view('organisasi.data-list-organisasi', ['data' => $data]);
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        return $this->organisasi->getListByKabId($term, $this->auth->getKabIdByOrganisasiId());
    }

    /**
     * Update organsiasi
     * @param $id
     */
    public function update($id)
    {

    }

    /**
     * Delete Organisasi saat ini
     * Not allowed
     *
     * @param $id
     */
    public function delete($id)
    {

    }

    /**
     * menampilkan detail Organsiasi
     *
     * @param $id
     * return \View
     */
    public function show($id)
    {

    }

} 