<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/16/2014
 * Time: 18:35
 */

namespace Simdes\Repositories\RKPDesa;


use Simdes\Models\RKPDesa\RKPDesa;

/**
 * Interface RKPDesaRepositoryInterface
 *
 * @package Simdes\Repositories\RKPDesa
 */
interface RKPDesaRepositoryInterface
{
    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id,$program_id);

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
     * @param RKPDesa $RKPDesa
     * @param array $data
     *
     * @return mixed
     */
    public function update(RKPDesa $RKPDesa, array $data);

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
     * @return mixed
     */
    public function getListKegiatan();

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir1($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir2($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function danaAPBN($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function apbProv($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function apbKab($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function apbDesa($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function swasta($organisasi_id);
}