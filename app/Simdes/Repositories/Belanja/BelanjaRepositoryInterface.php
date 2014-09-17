<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/19/2014
 * Time: 06:54
 */

namespace Simdes\Repositories\Belanja;


use Simdes\Models\Belanja\Belanja;

/**
 * Interface BelanjaRepositoryInterface
 *
 * @package Simdes\Repositories\Belanja
 */
interface BelanjaRepositoryInterface
{
    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id);

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param Belanja $belanja
     * @param array $data
     *
     * @return mixed
     */
    public function update(Belanja $belanja, array $data);

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
    public function findById($id);

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
     * @param $id
     * @return mixed
     */
    public function getText($id);

    /**
     * @param $kelompok_id
     * @param $jenis_id
     * @param $obyek_id
     * @param $rincian_obyek_id
     * @return mixed
     */
    public function getKodeRekening($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);

    /**
     * @param $id
     * @return mixed
     */
    public function getKode($id);

    /**
     * @param $organisasi_id
     * @param $term
     * @return mixed
     */
    public function autocomplete($organisasi_id, $term);

    /**
     * @return mixed
     */
    public function getHistoryForm();

    /**
     * @param Belanja $belanja
     * @param array $data
     * @return mixed
     */
    public function setHistory(Belanja $belanja, array $data);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findByOrganisasiId($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getCountBelanja($organisasi_id);
}