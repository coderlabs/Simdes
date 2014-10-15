<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:10
 */

namespace Simdes\Repositories\Akun;

use Simdes\Models\Akun\RincianObyek;

/**
 * Interface RincianObyekRepositoryInterface
 *
 * @package Simdes\Repositories\Akun
 */
interface RincianObyekRepositoryInterface {

    /**
     * @param $term
     * @param $organisasi
     *
     * @return mixed
     */
    public function findAll($term,$organisasi);

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
     * @param RincianObyek $rincianObyek
     * @param array        $data
     *
     * @return mixed
     */
    public function update(RincianObyek $rincianObyek,array $data);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function delete($id,$organisasi_id);

    /**
     * @param $obyek_id
     *
     * @return mixed
     */
    public function findByIdObyek($obyek_id);

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id,$organisasi_id);

    /**
     * @return mixed
     */
    public function getCreationForm();

    /**
     * @return mixed
     */
    public function getEditForm();

    /**
     * @param $obyek_id
     * @return mixed
     */
    public function findIsExists($obyek_id);
} 