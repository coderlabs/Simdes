<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:52
 */

namespace Simdes\Repositories\RPJMDesa;


use Simdes\Models\RPJMDesa\Pemetaan;

/**
 * Interface PemetaanRepositoryInterface
 *
 * @package Simdes\Repositories\RPJMDesa
 */
interface PemetaanRepositoryInterface {

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
     * @param Pemetaan $pemetaan
     * @param array    $data
     *
     * @return mixed
     */
    public function update(Pemetaan $pemetaan,array $data);

    /**
     * @return mixed
     */
    public function getCreationForm();

    /**
     * @return mixed
     */
    public function getEditForm();

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id,$organisasi_id);
} 