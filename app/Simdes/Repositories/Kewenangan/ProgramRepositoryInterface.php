<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:19
 */

namespace Simdes\Repositories\Kewenangan;


use Simdes\Models\RPJMDesa\Program;

/**
 * Interface ProgramRepositoryInterface
 *
 * @package Simdes\Repositories\Kewenangan
 */
interface ProgramRepositoryInterface
{
    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term,$organisasi_id);

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
     * @param \Simdes\Models\Kewenangan\Program $program
     * @param array $data
     *
     * @return mixed
     */
    public function update(\Simdes\Models\Kewenangan\Program $program, array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id,$organisasi_id);

    /**
     * @return mixed
     */
    public function getCreationForm();

    /**
     * @return mixed
     */
    public function getEditForm();

    /**
     * @param $bidang_id
     *
     * @return mixed
     */
    public function findByIdBidang($bidang_id);

    /**
     * @param $bidang_id
     * @return mixed
     */
    public function getList($bidang_id,$organisasi_id);

    /**
     * menampilkan program untuk dropdown
     * diakses oleh RPJMDesa
     *
     * @return mixed
     */
    public function getListProgram($organisasi_id);

    /**
     * @param $bidang_id
     * @return mixed
     */
    public function findIsExists($bidang_id);
}