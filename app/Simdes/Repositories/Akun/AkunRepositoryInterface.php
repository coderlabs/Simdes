<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:05
 */

namespace Simdes\Repositories\Akun;

use Simdes\Models\Akun\Akun;

/**
 * Interface AkunRepositoryInterface
 *
 * @package Simdes\Repositories\Akun
 */
interface AkunRepositoryInterface
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
     * @param Akun $akun
     * @param array $data
     *
     * @return mixed
     */
    public function update(Akun $akun, array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id);

    /**
     * Get list data akun untuk ditampilkan di dropdown
     *
     * @return mixed
     */
    public function getList();

}