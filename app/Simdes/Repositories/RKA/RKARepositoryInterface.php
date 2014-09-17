<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/29/2014
 * Time: 18:44
 */

namespace Simdes\Repositories\RKA;


    /**
     * Interface RKARepositoryInterface
     *
     * @package Simdes\Repositories\rka
     */
/**
 * Interface RKARepositoryInterface
 *
 * @package Simdes\Repositories\rka
 */
/**
 * Interface RKARepositoryInterface
 * @package Simdes\Repositories\rka
 */
interface RKARepositoryInterface
{

    /**
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findRKAPendapatan($organisasi_id);

    /**
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findRKABelanja($organisasi_id);

    /**
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findRKAPembiayaan($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getSumPendapatan($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getSumBelanja($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getSumPembiayaan($organisasi_id);

}