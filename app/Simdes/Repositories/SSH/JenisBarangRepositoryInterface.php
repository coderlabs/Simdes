<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:23
 */

namespace Simdes\Repositories\SSH;


use Simdes\Models\SSH\JenisBarang;

/**
 * Interface JenisBarangRepositoryInterface
 *
 * @package Simdes\Repositories\ssh
 */
interface JenisBarangRepositoryInterface
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
     * @param JenisBarang $jenisBarang
     * @param array $data
     *
     * @return mixed
     */
    public function update(JenisBarang $jenisBarang, array $data);

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
     * @param $kelompok_id
     * @return mixed
     */
    public function getListJenisBarang($kelompok_id);

    /**
     * @param $kelompok_id
     * @return mixed
     */
    public function findIsExists($kelompok_id);

}