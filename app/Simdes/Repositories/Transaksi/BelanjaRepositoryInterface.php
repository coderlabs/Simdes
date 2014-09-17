<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/9/2014
 * Time: 09:16
 */

namespace Simdes\Repositories\Transaksi;


use Simdes\Models\Transaksi\Belanja;

interface BelanjaRepositoryInterface
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
     * @param Belanja $belanja
     * @param array $data
     * @return mixed
     */
    public function update(Belanja $belanja, array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    public function posting(Belanja $belanja);

    public function findByDate($term, $dateStart,$dateEnd,$organisasi_id);

    public function findForBku($dateStart,$dateEnd,$organisasi_id);

    public function jumlahBulanIni($dateStart,$dateEnd,$organisasi_id);

    public function jumlahSampaiBulanIni($organisasi_id);

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