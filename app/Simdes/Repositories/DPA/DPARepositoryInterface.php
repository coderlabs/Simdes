<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/3/2014
 * Time: 09:11
 */

namespace Simdes\Repositories\DPA;

use Simdes\Models\Belanja\Belanja;
use Simdes\Models\Pembiayaan\Pembiayaan;
use Simdes\Models\Pendapatan\Pendapatan;


/**
 * Interface DPARepositoryInterface
 * @package Simdes\Repositories\dpa
 */
interface DPARepositoryInterface
{

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findDPAPendapatan($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findDPABelanja($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findDPAPembiayaan($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function sumDPAPendapatan($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function sumDPABelanja($organisasi_id);

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function sumDPAPembiayaan($organisasi_id);

    /**
     * @param Pendapatan $pendapatan
     * @param array $data
     * @return mixed
     */
    public function setDPAPendapatan(Pendapatan $pendapatan, array $data);

    /**
     * @param Belanja $belanja
     * @param array $data
     * @return mixed
     */
    public function setDPABelanja(Belanja $belanja, array $data);

    /**
     * @param Pembiayaan $pembiayaan
     * @param array $data
     * @return mixed
     */
    public function setDPAPembiayaan(Pembiayaan $pembiayaan, array $data);

} 