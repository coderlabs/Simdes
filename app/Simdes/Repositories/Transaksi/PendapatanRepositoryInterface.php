<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/7/2014
 * Time: 06:18
 */

namespace Simdes\Repositories\Transaksi;

use Simdes\Models\Transaksi\Pendapatan;

/**
 * Interface PendapatanRepositoryInterface
 * @package Simdes\Repositories\Transaksi
 */
interface PendapatanRepositoryInterface
{

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id);

    public function findByDate($term, $dateStart,$dateEnd,$organisasi_id);

    public function findForBku($dateStart,$dateEnd,$organisasi_id);

    public function jumlahBulanIni($dateStart,$dateEnd,$organisasi_id);

    public function jumlahSampaiBulanIni($organisasi_id);

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
     * @param Pendapatan $pendapatan
     * @param array $data
     * @return mixed
     */
    public function update(Pendapatan $pendapatan, array $data);

    public function posting(Pendapatan $pendapatan);

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
    public function countTrPendapatan($organisasi_id);

} 