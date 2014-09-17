<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/9/2014
 * Time: 09:58
 */

namespace Simdes\Repositories\Transaksi;


use Simdes\Models\Pembiayaan\Pembiayaan;

/**
 * Interface PembiayaanRepositoryInterface
 * @package Simdes\Repositories\Transaksi
 */
interface PembiayaanRepositoryInterface
{
    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param Pembiayaan $pembiayaan
     * @param array $data
     * @return mixed
     */
    public function update(Pembiayaan $pembiayaan, array $data);

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
    public function sum($organisasi_id);

} 