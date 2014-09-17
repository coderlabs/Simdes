<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:09
 */

namespace Simdes\Repositories\Akun;

use Simdes\Models\Akun\Obyek;

/**
 * Interface ObyekRepositoryInterface
 *
 * @package Simdes\Repositories\Akun
 */
interface ObyekRepositoryInterface
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
     * @param Obyek $obyek
     * @param array $data
     *
     * @return mixed
     */
    public function update(Obyek $obyek, array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id,$organisasi_id);

    /**
     * @param $jenis_id
     *
     * @return mixed
     */
    public function findByIdJenis($jenis_id);

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
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($organisasi_id);

    /**
     * @param $jenis_id
     * @return mixed
     */
    public function findIsExists($jenis_id);

}