<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/18/2014
 * Time: 09:03
 */

namespace Simdes\Repositories\Kewenangan;


use Simdes\Models\Kewenangan\Kegiatan;

/**
 * Interface KegiatanRepositoryInterface
 *
 * @package Simdes\Repositories\Kewenangan
 */
interface KegiatanRepositoryInterface
{
    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);


    /**
     * @param Kegiatan $kegiatan
     * @param array $data
     *
     * @return mixed
     */
    public function update(Kegiatan $kegiatan, array $data);

    /**
     * @param $id
     * @param $organisasi_id
     * @return mixed
     */
    public function delete($id, $organisasi_id);

    /**
     * @return mixed
     */
    public function getCreationForm();

    /**
     * @return mixed
     */
    public function getEditForm();

    /**
     * @param $kegiatan_id
     * @return mixed
     */
    public function getStringKegiatan($kegiatan_id);

    /**
     * @return mixed
     */
    public function getList($organisasi_id);

    /**
     * Menampilkan data dropdown kegiatan
     * dikases oleh RKPDesa
     *
     * @param $program_id
     * @return mixed
     */
    public function getListKegiatan($program_id, $organisasi_id);

    /**
     * @param $program_id
     * @return mixed
     */
    public function findIsExists($program_id);
} 