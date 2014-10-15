<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:08
 */

namespace Simdes\Repositories\Akun;

use Simdes\Models\Akun\Jenis;

/**
 * Interface JenisRepositoryInterface
 *
 * @package Simdes\Repositories\Akun
 */
interface JenisRepositoryInterface
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
     * @param Jenis $jenis
     * @param array $data
     *
     * @return mixed
     */
    public function update(Jenis $jenis, array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $kelompok_id
     *
     * @return mixed
     */
    public function findByIdKelompok($kelompok_id);

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
    public function getCreationForm();

    /**
     * @return mixed
     */
    public function getEditForm();

    /**
     * @return mixed
     */
    public function getList();

    /**
     * @param $kelompok_id
     * @return mixed
     */
    public function findIsExists($kelompok_id);
}