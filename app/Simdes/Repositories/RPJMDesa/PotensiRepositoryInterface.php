<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 11:54
 */

namespace Simdes\Repositories\RPJMDesa;


use Simdes\Models\RPJMDesa\Potensi;

/**
 * Interface PotensiRepositoryInterface
 *
 * @package Simdes\Repositories\RPJMDesa
 */
interface PotensiRepositoryInterface
{

    /**
     * @param $term
     * @param $masalah_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $masalah_id, $organisasi_id);

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
     * @param Potensi $potensi
     * @param array   $data
     *
     * @return mixed
     */
    public function update(Potensi $potensi, array $data);

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
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id);

    /**
     * @param $masalah_id
     * @return mixed
     */
    public function findByMasalahId($masalah_id);
} 