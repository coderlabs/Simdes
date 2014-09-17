<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/3/2014
 * Time: 09:10
 */

namespace DPA;

use RKA\RKAController as RKA;
use Simdes\Repositories\Belanja\BelanjaRepositoryInterface as Belanja;
use Simdes\Repositories\DPA\DPARepositoryInterface as DPA;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface as Organisasi;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface as Pejabat;
use Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface as Pembiayaan;
use Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface as Pendapatan;
use Simdes\Repositories\User\UserRepositoryInterface as UserAuth;

/**
 * Class DPAController
 * @package dpa
 */
class DPAController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;
    /**
     * @var \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface
     */
    protected $pendapatan;
    /**
     * @var \Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface
     */
    protected $pembiayaan;
    /**
     * @var \Simdes\Repositories\Belanja\BelanjaRepositoryInterface
     */
    protected $belanja;
    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;
    /**
     * @var \Simdes\Repositories\DPA\DPARepositoryInterface
     */
    protected $dpa;

    /**
     * @param Pendapatan $pendapatan
     * @param Belanja $belanja
     * @param DPA $dpa
     * @param Pembiayaan $pembiayaan
     * @param UserAuth $auth
     * @param Organisasi $organisasi
     * @param Pejabat $pejabat
     * @param RKA $rka
     */
    public function __construct(
        Pendapatan $pendapatan,
        Belanja $belanja,
        DPA $dpa,
        Pembiayaan $pembiayaan,
        UserAuth $auth,
        Organisasi $organisasi,
        Pejabat $pejabat,
        RKA $rka
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->pendapatan = $pendapatan;
        $this->belanja = $belanja;
        $this->pembiayaan = $pembiayaan;
        $this->dpa = $dpa;
        $this->organisasi = $organisasi;
        $this->pejabat = $pejabat;
        $this->rka = $rka;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $pendapatan = $this->dpa->findDPAPendapatan($this->auth->getOrganisasiId());
        $belanja = $this->dpa->findDPABelanja($this->auth->getOrganisasiId());
        $pembiayaan = $this->dpa->findDPAPembiayaan($this->auth->getOrganisasiId());

        $this->view('dpa.data-dpa', [
            'pendapatan' => $pendapatan,
            'belanja'    => $belanja,
            'pembiayaan' => $pembiayaan,
        ]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formulir1()
    {
        $pendapatan = $this->dpa->findDPAPendapatan($this->auth->getOrganisasiId());
        $belanja = $this->dpa->findDPABelanja($this->auth->getOrganisasiId());
        $pembiayaan = $this->dpa->findDPAPembiayaan($this->auth->getOrganisasiId());
        $jumlahPendapatan = $this->dpa->sumDPAPendapatan($this->auth->getOrganisasiId());
        $jumlahBelanja = $this->dpa->sumDPABelanja($this->auth->getOrganisasiId());
        $jumlahPembiayaan = $this->dpa->sumDPAPembiayaan($this->auth->getOrganisasiId());
        $total = $jumlahPendapatan + $jumlahBelanja + $jumlahPembiayaan;

        // data umum Organisasi
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        // get nama pejabat desa penanda tangan dokumen rka Formulir1
        // dengan @param string $fungsi, default untuk formulir
        // rka Desa ini adalah kades, @todo:evaluasi lagi
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');

        // tanggal sekarang
        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));

        $bagiPendapatan = $jumlahPendapatan / 4;
        $bagiBelanja = $jumlahBelanja / 4;
        $bagiPembiayaan = $jumlahPembiayaan / 4;

        $pdf = \App::make('dompdf');
        $pdf->loadView('dpa.dpa-formulir-1', [
            'organisasi'     => $organisasi,
            'pendapatan'     => $pendapatan,
            'belanja'        => $belanja,
            'pembiayaan'     => $pembiayaan,
            'jml_pendapatan' => $jumlahPendapatan,
            'jml_belanja'    => $jumlahBelanja,
            'jml_pembiayaan' => $jumlahPembiayaan,
            'total'          => $total,
            'tgl'            => $tgl,
            'kades'          => $kades,
            'bagiPendapatan' => $bagiPendapatan,
            'bagiBelanja'    => $bagiBelanja,
            'bagiPembiayaan' => $bagiPembiayaan,
        ]);
        $random = str_random(10);
        $file = 'data-dpa-formulir-1-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('portrait')->download($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formulir2()
    {
        $pendapatan = $this->dpa->findDPAPendapatan($this->auth->getOrganisasiId());
        $belanja = $this->dpa->findDPABelanja($this->auth->getOrganisasiId());
        $pembiayaan = $this->dpa->findDPAPembiayaan($this->auth->getOrganisasiId());
        $jumlahPendapatan = $this->dpa->sumDPAPendapatan($this->auth->getOrganisasiId());
        $jumlahBelanja = $this->dpa->sumDPABelanja($this->auth->getOrganisasiId());
        $jumlahPembiayaan = $this->dpa->sumDPAPembiayaan($this->auth->getOrganisasiId());
        $total = $jumlahPendapatan + $jumlahBelanja + $jumlahPembiayaan;

        // data umum Organisasi
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        // get nama pejabat desa penanda tangan dokumen rka Formulir1
        // dengan @param string $fungsi, default untuk formulir
        // rka Desa ini adalah kades, @todo:evaluasi lagi
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');

        // tanggal sekarang
        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));

        $bagiPendapatan = $jumlahPendapatan / 4;
        $pdf = \App::make('dompdf');
        $pdf->loadView('dpa.dpa-formulir-2', [
            'organisasi'     => $organisasi,
            'pendapatan'     => $pendapatan,
            'jml_pendapatan' => $jumlahPendapatan,
            'tgl'            => $tgl,
            'bagi'           => $bagiPendapatan,
            'kades'          => $kades,
        ]);
        $random = str_random(10);
        $file = 'data-dpa-formulir-1-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('portrait')->download($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formulir3()
    {
        $pendapatan = $this->dpa->findDPAPendapatan($this->auth->getOrganisasiId());
        $belanja = $this->dpa->findDPABelanja($this->auth->getOrganisasiId());
        $pembiayaan = $this->dpa->findDPAPembiayaan($this->auth->getOrganisasiId());
        $jumlahPendapatan = $this->dpa->sumDPAPendapatan($this->auth->getOrganisasiId());
        $jumlahBelanja = $this->dpa->sumDPABelanja($this->auth->getOrganisasiId());
        $jumlahPembiayaan = $this->dpa->sumDPAPembiayaan($this->auth->getOrganisasiId());
        $total = $jumlahPendapatan + $jumlahBelanja + $jumlahPembiayaan;

        // data umum Organisasi
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        // get nama pejabat desa penanda tangan dokumen rka Formulir1
        // dengan @param string $fungsi, default untuk formulir
        // rka Desa ini adalah kades, @todo:evaluasi lagi
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');

        // tanggal sekarang
        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));

        $pdf = \App::make('dompdf');
        $bagiBelanja = $jumlahBelanja / 4;
        $pdf->loadView('dpa.dpa-formulir-3', [
            'organisasi'  => $organisasi,
            'belanja'     => $belanja,
            'jml_belanja' => $jumlahBelanja,
            'tgl'         => $tgl,
            'bagi'        => $bagiBelanja,
            'kades'       => $kades,
        ]);
        $random = str_random(10);
        $file = 'data-dpa-formulir-1-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('portrait')->download($file);
    }
}