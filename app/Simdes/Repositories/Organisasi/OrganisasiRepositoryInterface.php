<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/15/2014
 * Time: 19:04
 */

namespace Simdes\Repositories\Organisasi;

use Simdes\Models\Organisasi\Organisasi;


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
     *
     * @return mixed
     */
    public function update(Organisasi $organisasi, array $data);

    public function getCreationForm();

    public function getEditForm();

    public function findById($organisasi_id);

    public function getKode($organisasi_id);

    public function getNama($organisasi_id);

}