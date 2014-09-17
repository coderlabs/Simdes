<?php

namespace Simdes\Repositories\Pendapatan;

use Simdes\Models\Pendapatan\Pendapatan;

/**
 * Interface PendapatanRepositoryInterface
 *
 * @package Simdes\Repositories\Pendapatan
 */
interface PendapatanRepositoryInterface
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
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param Pendapatan $pendapatan
     * @param array $data
     * @return mixed
     */
    public function update(Pendapatan $pendapatan, array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

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
    public function getCountPendapatan($organisasi_id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function setRKA($id);

    /**
     * @param $id
     * @return mixed
     */
    public function unsetRKA($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function setDPA($id);

    /**
     * @param $id
     * @return mixed
     */
    public function unsetDPA($id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($organisasi_id, $term);

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
     * @param Pendapatan $pendapatan
     * @param array $data
     * @return mixed
     */
    public function setHistory(Pendapatan $pendapatan, array $data);

    /**
     * @return mixed
     */
    public function getHistoryForm();

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
    public function findByOrganisasiId($organisasi_id);

}