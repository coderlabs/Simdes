<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/14
 * Time: 1:27 PM
 */

namespace Simdes\Repositories\Akun;

use Simdes\Models\Akun\Kelompok;

/**
 * Interface KelompokRepositoryInterface
 *
 * @package Simdes\Repositories\Akun
 */
interface KelompokRepositoryInterface
{

    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @param Kelompok $kelompok
     * @param array $data
     *
     * @return mixed
     */
    public function update(Kelompok $kelompok, array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $akun_id
     *
     * @return mixed
     */
    public function findByIdAkun($akun_id);

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id);

    /**
     * @return mixed
     */
    public function getEditForm();

    /**
     * @return mixed
     */
    public function getCreationForm();

    public function getList();

    public function findIsExists($akun_id);

}