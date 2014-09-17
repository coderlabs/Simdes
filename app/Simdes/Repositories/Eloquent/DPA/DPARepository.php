<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/3/2014
 * Time: 09:13
 */

namespace Simdes\Repositories\Eloquent\DPA;


use Simdes\Models\Belanja\Belanja;
use Simdes\Models\Pembiayaan\Pembiayaan;
use Simdes\Models\Pendapatan\Pendapatan;
use Simdes\Repositories\DPA\DPARepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;

/**
 * Class DPARepository
 * @package Simdes\Repositories\Eloquent\dpa
 */
class DPARepository extends AbstractRepository implements DPARepositoryInterface
{
    /**
     * @var \Simdes\Models\Pendapatan\Pendapatan
     */
    protected $pendapatan;
    /**
     * @var \Simdes\Models\Belanja\Belanja
     */
    protected $belanja;
    /**
     * @var \Simdes\Models\Pembiayaan\Pembiayaan
     */
    protected $pembiayaan;

    /**
     * @param Pendapatan $pendapatan
     * @param Belanja $belanja
     * @param Pembiayaan $pembiayaan
     */
    public function __construct(Pendapatan $pendapatan, Belanja $belanja, Pembiayaan $pembiayaan)
    {
        $this->pendapatan = $pendapatan;
        $this->belanja = $belanja;
        $this->pembiayaan = $pembiayaan;
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findDPAPendapatan($organisasi_id)
    {
        $dpaPendapatan = $this->pendapatan->where('is_dpa', '=', 1)->where('organisasi_id', '=', $organisasi_id)->get();
        return $dpaPendapatan;
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findDPABelanja($organisasi_id)
    {
        $dpaBelanja = $this->belanja->where('is_dpa', '=', 1)->where('organisasi_id', '=', $organisasi_id)->get();
        return $dpaBelanja;
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function findDPAPembiayaan($organisasi_id)
    {
        $dpaPembiayaan = $this->pembiayaan->where('is_dpa', '=', 1)->where('organisasi_id', '=', $organisasi_id)->get();
        return $dpaPembiayaan;
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function sumDPAPendapatan($organisasi_id)
    {
        return $this->pendapatan->where('is_dpa', '=', 1)->where('organisasi_id', '=', $organisasi_id)->sum('jumlah');
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function sumDPABelanja($organisasi_id)
    {
        return $this->belanja->where('is_dpa', '=', 1)->where('organisasi_id', '=', $organisasi_id)->sum('jumlah');
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function sumDPAPembiayaan($organisasi_id)
    {
        return $this->pembiayaan->where('is_dpa', '=', 1)->where('organisasi_id', '=', $organisasi_id)->sum('jumlah');
    }

    /**
     * @param Pendapatan $pendapatan
     * @param array $data
     * @return Pendapatan
     */
    public function setDPAPendapatan(Pendapatan $pendapatan, array $data)
    {
        $pendapatan->is_dpa = 1;
        $pendapatan->save();
        return $pendapatan;
    }

    /**
     * @param Belanja $belanja
     * @param array $data
     * @return Belanja
     */
    public function setDPABelanja(Belanja $belanja, array $data)
    {
        $belanja->is_dpa = 1;
        $belanja->save();
        return $belanja;
    }

    /**
     * @param Pembiayaan $pembiayaan
     * @param array $data
     * @return Pembiayaan
     */
    public function setDPAPembiayaan(Pembiayaan $pembiayaan, array $data)
    {
        $pembiayaan->is_dpa = 1;
        $pembiayaan->save();
        return $pembiayaan;
    }

}