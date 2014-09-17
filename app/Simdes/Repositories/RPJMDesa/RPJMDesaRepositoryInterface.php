<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:22
 */

namespace Simdes\Repositories\RPJMDesa;


use Simdes\Models\RPJMDesa\RPJMDesa;

/**
 * Interface RPJMDesaRepositoryInterface
 *
 * @package Simdes\Repositories\RPJMDesa
 */
interface RPJMDesaRepositoryInterface
{

    /**
     * @param $term
     * @param $user_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $user_id, $organisasi_id);

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
    public function findbyId($id);

    /**
     * @param RPJMDesa $RPJMDesa
     * @param array $data
     *
     * @return mixed
     */
    public function update(RPJMDesa $RPJMDesa, array $data);

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
     * @param $id
     *
     * @return mixed
     */
    public function findMasalah($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findMisi($id);

    /**
     * Get data Filter by organisasi_id dan id
     *
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getListProgram($organisasi_id);
}