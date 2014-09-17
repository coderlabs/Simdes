<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:19
 */

namespace Simdes\Repositories\Kewenangan;

use Simdes\Models\Kewenangan\Fungsi;

/**
 * Interface BidangRepositoryInterface
 * @package Simdes\Repositories\Kewenangan
 */
interface FungsiRepositoryInterface
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
     * @param Fungsi $fungsi
     * @param array $data
     * @return mixed
     */
    public function update(Fungsi $fungsi, array $data);

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
     * @param $kewenangan_id
     * @return mixed
     */
    public function findByKewenanganId($kewenangan_id);

    /**
     * @param $kewenangan_id
     * @return mixed
     */
    public function findIsExists($kewenangan_id);

    /**
     * @return mixed
     */
    public function getList();
}