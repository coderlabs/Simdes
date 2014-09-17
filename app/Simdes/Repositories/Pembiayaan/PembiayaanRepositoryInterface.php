<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 19:19
 */

namespace Simdes\Repositories\Pembiayaan;

use Simdes\Models\Pembiayaan\Pembiayaan;

/**
 * Interface PembiayaanRepositoryInterface
 *
 * @package Simdes\Repositories\Pembiayaan
 */
interface PembiayaanRepositoryInterface
{
    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id);

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
     * @param Pembiayaan $pembiayaan
     * @param array $data
     *
     * @return mixed
     */
    public function update(Pembiayaan $pembiayaan, array $data);

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
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function getCountPembiayaan($organisasi_id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function setRKA($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function setDPA($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function unsetRKA($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function unsetDPA($id);

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function realisasiAnggaran($id, array $data);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findByOrganisasiId($organisasi_id);

    /**
     * @param $organisasi_id
     * @param null $kelompok_id
     * @return mixed
     */
    public function getTotPembiayaan($organisasi_id, $kelompok_id = null);
}