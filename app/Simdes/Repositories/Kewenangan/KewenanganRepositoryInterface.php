<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:19
 */

namespace Simdes\Repositories\Kewenangan;

use Simdes\Models\Kewenangan\Kewenangan;

/**
 * Interface KewenanganRepositoryInterface
 * @package Simdes\Repositories\Kewenangan
 */
interface KewenanganRepositoryInterface
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
     * @param Kewenangan $kewenangan
     * @param array $data
     * @return mixed
     */
    public function update(Kewenangan $kewenangan, array $data);

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
     * @return mixed
     */
    public function getList();


}