<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:26
 */

namespace Simdes\Repositories\SSH;


use Simdes\Models\SSH\RincianObyekBarang;

/**
 * Interface RincianObyekBarangRepositoryInterface
 *
 * @package Simdes\Repositories\ssh
 */
interface RincianObyekBarangRepositoryInterface
{
    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term);

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
     * @param RincianObyekBarang $rincianObyekBarang
     * @param array $data
     *
     * @return mixed
     */
    public function update(RincianObyekBarang $rincianObyekBarang, array $data);

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
     * @param $term
     * @return mixed
     */
    public function autocomplete($term);

    /**
     * @param $obyek_id
     * @return mixed
     */
    public function findIsExists($obyek_id);
}