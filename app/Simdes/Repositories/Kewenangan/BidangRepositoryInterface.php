<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:19
 */

namespace Simdes\Repositories\Kewenangan;

use Simdes\Models\Kewenangan\Bidang;

/**
 * Interface BidangRepositoryInterface
 * @package Simdes\Repositories\Kewenangan
 */
interface BidangRepositoryInterface
{
    /**
     * @param $term
     * @return mixed
     */
    public function findAll($term);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param Bidang $bidang
     * @param array $data
     * @return mixed
     */
    public function update(Bidang $bidang, array $data);

    /**
     * @param $id
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
     * @param $fungsi_id
     * @return mixed
     */
    public function findByKewenanganId($fungsi_id);

    /**
     * @param $fungsi_id
     * @return mixed
     */
    public function getList($fungsi_id);

    /**
     * @param $fungsi_id
     * @return mixed
     */
    public function findIsExists($fungsi_id);
}