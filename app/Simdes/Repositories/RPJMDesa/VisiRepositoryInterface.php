<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:28
 */

namespace Simdes\Repositories\RPJMDesa;


use Simdes\Models\RPJMDesa\Visi;

/**
 * Interface VisiRepositoryInterface
 *
 * @package Simdes\Repositories\RPJMDesa
 */
interface VisiRepositoryInterface {

    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term,  $organisasi_id);

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
     * @param Visi  $visi
     * @param array $data
     *
     * @return mixed
     */
    public function update(Visi $visi,array $data);

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
} 