<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/31/2014
 * Time: 18:15
 */

namespace Simdes\Repositories\Pejabat;


/**
 * Interface PejabatDesaRepositoryInterface
 *
 * @package Simdes\Repositories\Pejabat
 */
use Simdes\Models\Pejabat\PejabatDesa;

/**
 * Interface PejabatDesaRepositoryInterface
 * @package Simdes\Repositories\Pejabat
 */
interface PejabatDesaRepositoryInterface
{

    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param PejabatDesa $pejabat
     * @param array $data
     * @return mixed
     */
    public function update(PejabatDesa $pejabat, array $data);

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findById($id, $organisasi_id);

    /**
     * @param $organisasi_id
     * @param $fungsi
     *
     * @return mixed
     */
    public function getPejabat($organisasi_id, $fungsi);

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
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getKades($organisasi_id);
    public function getBendahara($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getSekdes($organisasi_id);

    public function getCamat($organisasi_id);
    public function getBupati($organisasi_id);

}