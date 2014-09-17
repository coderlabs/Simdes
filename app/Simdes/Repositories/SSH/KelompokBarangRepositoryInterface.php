<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:20
 */

namespace Simdes\Repositories\SSH;


use Simdes\Models\SSH\KelompokBarang;

/**
 * Interface KelompokBarangRepositoryInterface
 *
 * @package Simdes\Repositories\ssh
 */
interface KelompokBarangRepositoryInterface
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
     * @param KelompokBarang $kelompokBarang
     * @param array $data
     *
     * @return mixed
     */
    public function update(KelompokBarang $kelompokBarang, array $data);

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
     * @param $kelas_id
     * @return mixed
     */
    public function getListKelompokBarang($kelas_id);

    /**
     * @param $kelas_id
     * @return mixed
     */
    public function findIsExists($kelas_id);
}