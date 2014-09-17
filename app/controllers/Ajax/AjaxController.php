<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 22:03
 */

namespace Ajax;

use Illuminate\Support\Facades\Input;
use Simdes\Repositories\Akun\AkunRepositoryInterface;
use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\Kewenangan\BidangRepositoryInterface;
use Simdes\Repositories\Kewenangan\FungsiRepositoryInterface;
use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Repositories\Kewenangan\KewenanganRepositoryInterface;
use Simdes\Repositories\Kewenangan\ProgramRepositoryInterface;
use Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface;
use Simdes\Repositories\RKPDesa\RKPDesaRepositoryInterface;
use Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface;
use Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class AjaxController
 *
 * @package controllers\Ajax
 */
class AjaxController extends \BaseController
{
    /**
     * @var
     */
    private $kelompok;
    /**
     * @var
     */
    private $jenis;
    /**
     * @var
     */
    private $obyek;
    /**
     * @var
     */
    private $rincianObyek;

    /**
     * @var \Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface
     */
    private $program;

    /**
     * @var \Simdes\Repositories\RKPDesa\RKPDesaRepositoryInterface
     */
    private $RKPDesa;

    /**
     * @var \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface
     */
    private $pendapatan;

    /**
     * @var \Simdes\Repositories\Kewenangan\KewenanganRepositoryInterface
     */
    private $kewenangan;
    /**
     * @var \Simdes\Repositories\Kewenangan\BidangRepositoryInterface
     */
    private $bidang;

    /**
     * @var ProgramRepositoryInterface
     */
    private $programKewenangan;

    /**
     * @var ProgramRepositoyInterface
     */
    private $rpjmProgram;

    /**
     * @var KegiatanRepositoryInterface
     */
    private $kegiatan;

    /**
     * @var FungsiRepositoryInterface
     */
    private $fungsi;

    /**
     * @param ProgramRepositoyInterface $rpjmProgram
     * @param AkunRepositoryInterface $akun
     * @param KelompokRepositoryInterface $kelompok
     * @param JenisRepositoryInterface $jenis
     * @param ObyekRepositoryInterface $obyek
     * @param RincianObyekRepositoryInterface $rincianObyek
     * @param ProgramRepositoyInterface $program
     * @param UserRepositoryInterface $auth
     * @param PendapatanRepositoryInterface $pendapatan
     * @param RKPDesaRepositoryInterface $RKPDesa
     * @param KewenanganRepositoryInterface $kewenangan
     * @param BidangRepositoryInterface $bidang
     * @param ProgramRepositoryInterface $programKewenangan
     * @param KegiatanRepositoryInterface $kegiatan
     */
    public function __construct(
        ProgramRepositoyInterface $rpjmProgram,
        AkunRepositoryInterface $akun,
        KelompokRepositoryInterface $kelompok,
        JenisRepositoryInterface $jenis,
        ObyekRepositoryInterface $obyek,
        RincianObyekRepositoryInterface $rincianObyek,
        ProgramRepositoyInterface $program,
        UserRepositoryInterface $auth,
        PendapatanRepositoryInterface $pendapatan,
        RKPDesaRepositoryInterface $RKPDesa,
        KewenanganRepositoryInterface $kewenangan,
        BidangRepositoryInterface $bidang,
        ProgramRepositoryInterface $programKewenangan,
        KegiatanRepositoryInterface $kegiatan,
        FungsiRepositoryInterface $fungsi

    )
    {

        $this->akun = $akun;
        $this->kelompok = $kelompok;
        $this->jenis = $jenis;
        $this->obyek = $obyek;
        $this->rincianObyek = $rincianObyek;
        $this->program = $program;
        $this->auth = $auth;
        $this->RKPDesa = $RKPDesa;
        $this->pendapatan = $pendapatan;
        $this->kewenangan = $kewenangan;
        $this->bidang = $bidang;
        $this->programKewenangan = $programKewenangan;
        $this->rpjmProgram = $rpjmProgram;
        $this->kegiatan = $kegiatan;
        $this->fungsi = $fungsi;

    }

    /**
     * Get data akun untuk drop down
     *
     * @return mixed
     */
    public function getAkun()
    {
        return $this->akun->getList();
    }


    /**
     * Get data kelompok untuk drop down
     *
     * @post int $akun_id
     * @return mixed
     */
    public function getKelompok()
    {
        $akun_id = Input::get('akun_id');

        return $this->kelompok->findByIdAkun($akun_id);
    }

    /**
     * Get data jenis untuk drop down
     *
     * @post int $kelompok_id
     * @return mixed
     */
    public function getJenis()
    {
        $kelompok_id = Input::get('kelompok_id');

        return $this->jenis->findByIdKelompok($kelompok_id);
    }

    /**
     * Get data obyek untuk drop down
     *
     * @post int $jenis_id
     * @return mixed
     */
    public function getObyek()
    {
        $jenis_id = Input::get('jenis_id');

        return $this->obyek->findByIdJenis($jenis_id);
    }

    /**
     * Get data rincian obyek untuk drop down
     *
     * @post int $obyek_id
     * @return mixed
     */
    public function getRincianObyek()
    {
        $obyek_id = Input::get('obyek_id');

        return $this->rincianObyek->findByIdObyek($obyek_id);
    }

    /**
     * @return mixed
     */
    public function getListKelompok()
    {
        return $this->kelompok->getList();
    }

    /**
     * @return mixed
     */
    public function getListJenis()
    {
        return $this->jenis->getList();

    }

    /**
     * @return mixed
     */
    public function getListObyek()
    {
        return $this->obyek->getList($this->auth->getOrganisasiId());
    }

    /**
     * @return mixed
     */
    public function getListKegiatanRKPDesa()
    {
        return $this->RKPDesa->getListKegiatan();
    }

    /**
     * @return mixed
     */
    public function getCountPendapatan()
    {
        return $this->pendapatan->getCountPendapatan($this->auth->getOrganisasiId());
    }

    /**
     * @return mixed
     */
    public function getListKewenangan()
    {
        return $this->kewenangan->getList();
    }

    /**
     * @return mixed
     */
    public function getListFungsi()
    {
        return $this->fungsi->getList();
    }

    /**
     * @return mixed
     */
    public function getListBidang()
    {
        $fungsi_id = $this->input('fungsi_id');
        return $this->bidang->getList($fungsi_id);
    }

    /**
     * @return mixed
     */
    public function getListProgram()
    {
        $bidang_id = $this->input('bidang_id');
        return $this->programKewenangan->getList($bidang_id, $this->auth->getOrganisasiId());
    }

    /**
     * menampilkan program dropdown
     * diakses oleh RPJMDesa
     *
     * @return mixed
     */
    public function listProgram()
    {
        return $this->programKewenangan->getListProgram($this->auth->getOrganisasiId());
    }

    /**
     * Menampilkan data prgoram yang telah diRPJMDesa kan
     * akan ditampilkan di RKPDesa outpurnya ada tiga
     * rpjmdesa_id|id|program
     *
     * @return mixed
     */
    public function listProgramRPJMDesa()
    {
        return $this->rpjmProgram->getListProgram($this->auth->getOrganisasiId());
    }

    /**
     * Menampilkan data dropdown kegiatan
     * diakses oleh RKPDesa
     *
     * @return mixed
     */
    public function getListKegiatan()
    {
        $program_id = $this->input('program_id');
        return $this->kegiatan->getListKegiatan($program_id, $this->auth->getOrganisasiId());
    }

}