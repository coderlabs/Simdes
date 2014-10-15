<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:33
 */

namespace Simdes\Repositories\RPJMDesa;


use Simdes\Models\RPJMDesa\Masalah;

/**
 * Interface MasalahRepositoryInterface
 *
 * @package Simdes\Repositories\RPJMDesa
 */
interface MasalahRepositoryInterface {

    /**
     * @param $term
     * @param $rpjmdesa_id
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term,$rpjmdesa_id,$organisasi_id);

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

    public function findByIdPemetaan($pemetaan_id);


    /**
     * @param Masalah $masalah
     * @param array   $data
     *
     * @return mixed
     */
    public function update(Masalah $masalah,array $data);

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
    public function findPotensi($id);


    /**
     * @param $id
     *
     * @return mixed
     */
    public function findPemetaan($id);


    /**
     * @param $id
     *
     * @return mixed
     */
    public function findProgram($id);

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id,$organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir5($organisasi_id);
}