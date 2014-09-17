<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:25
 */

namespace Simdes\Repositories\SSH;


use Simdes\Models\SSH\ObyekBarang;

/**
 * Interface ObyekBarangRepositoryInterface
 *
 * @package Simdes\Repositories\ssh
 */
interface ObyekBarangRepositoryInterface
{
    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);


    /**
     * @param ObyekBarang $obyekBarang
     * @param array $data
     *
     * @return mixed
     */
    public function update(ObyekBarang $obyekBarang, array $data);

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
     * @param $jenis_id
     *
     * @return mixed
     */
    public function getListObyekBarang($jenis_id);

    /**
     * @param $jenis_id
     * @return mixed
     */
    public function findIsExists($jenis_id);

}