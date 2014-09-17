<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:17
 */

namespace Simdes\Repositories\SSH;


use Simdes\Models\SSH\KelasBarang;

/**
 * Interface KelasBarangrepositoryInterface
 *
 * @package Simdes\Repositories\ssh
 */
interface KelasBarangRepositoryInterface
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
     * @param KelasBarang $kelasBarang
     * @param array $data
     *
     * @return mixed
     */
    public function update(KelasBarang $kelasBarang, array $data);

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
     * @return mixed
     */
    public function getListKelasBarang();
}