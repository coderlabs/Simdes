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
     * @param null $term
     * @return \View
     */
    public function index($term = null)
    {
        $data = $this->organisasi->getListByKabId($term,$this->auth->getKabIdByOrganisasiId());

        $this->view('organisasi.data-list-organisasi',['data' => $data]);
    }

    /**
     * Get list organisasi via ajax call
     *
     * @param $term
     * @return mixed
     */
    public function read($term)
    {
        return $this->organisasi->getListByKabId($term,$this->auth->getKabIdByOrganisasiId());
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