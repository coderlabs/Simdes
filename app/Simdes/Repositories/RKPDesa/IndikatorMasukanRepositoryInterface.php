<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/18/2014
 * Time: 13:21
 */

namespace Simdes\Repositories\RKPDesa;


use Simdes\Models\RKPDesa\IndikatorMasukan;

/**
 * Interface IndikatorMasukanRepositoryInterface
 *
 * @package Simdes\Repositories\RKPDesa
 */
interface IndikatorMasukanRepositoryInterface {
    /**
     * @param IndikatorMasukan $masukan
     * @param array            $data
     *
     * @return mixed
     */
    public function update(IndikatorMasukan $masukan, array $data);

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
    public function findByFilter($id,$organisasi_id);

} 