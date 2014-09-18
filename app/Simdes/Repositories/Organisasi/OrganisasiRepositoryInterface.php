<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 19:04
 */

namespace Simdes\Repositories\Organisasi;

use Simdes\Models\Organisasi\Organisasi;
use Simdes\Models\User\User;


/**
 * Interface OrganisasiRepositoryInterface
 *
 * @package Simdes\Repositories\Organisasi
 */
interface OrganisasiRepositoryInterface
{

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);


    /**
     * @param Organisasi $organisasi
     * @param array $data
     * @return mixed
     */
    public function update(Organisasi $organisasi, array $data);

    /**
     * @return mixed
     */
    public function getCreationForm();

    /**
     * @return mixed
     */
    public function getEditForm();

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getKode($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getNama($organisasi_id);

    /**
     * @param $term
     * @param $kab_id
     * @return mixed
     */
    public function getListByKabId($term,$kab_id);

}