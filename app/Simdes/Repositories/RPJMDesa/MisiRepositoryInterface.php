<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:29
 */

namespace Simdes\Repositories\RPJMDesa;


use Simdes\Models\RPJMDesa\Misi;

/**
 * Interface MisiRepositoryInterface
 *
 * @package Simdes\Repositories\RPJMDesa
 */
interface MisiRepositoryInterface {


    /**
     * @param $term
     * @param $rpjmdesa_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $rpjmdesa_id, $organisasi_id);

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
     * @param Misi  $misi
     * @param array $data
     *
     * @return mixed
     */public function update(Misi $misi, array $data);

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

    /**
     * @param $visi_id
     * @return mixed
     */
    public function findIsExists($visi_id);
}