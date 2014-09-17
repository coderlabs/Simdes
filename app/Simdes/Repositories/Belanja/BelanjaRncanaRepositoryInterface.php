<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/19/2014
 * Time: 06:54
 */

namespace Simdes\Repositories\Belanja;

use Simdes\Models\Belanja\RencanaBelanja;

/**
 * Interface BelanjaRencanaRepositoryInterface
 * @package Simdes\Repositories\Belanja
 */
interface BelanjaRencanaRepositoryInterface
{
    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id);

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param RencanaBelanja $rencanaBelanja
     * @param array $data
     * @return mixed
     */
    public function update(RencanaBelanja $rencanaBelanja, array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

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
     *
     * @return mixed
     */
    public function findById($id);
}