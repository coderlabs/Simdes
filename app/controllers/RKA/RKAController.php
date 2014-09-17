<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/29/2014
 * Time: 08:43
 */

namespace RKA;

use Barryvdh\DomPDF\PDF;
use Simdes\Repositories\Belanja\BelanjaRepositoryInterface;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface;
use Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface;
use Simdes\Repositories\RKA\RKARepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class RKAController
 *
 * @package rka
 */
class RKAController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface
     */
    protected $pendapatan;
    /**
     * @var \Simdes\Repositories\Belanja\BelanjaRepositoryInterface
     */
    protected $belanja;
    /**
     * @var \Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface
     */
    protected $pembiayaan;

    /**
     * @var \Simdes\Repositories\RKA\RKARepositoryInterface
     */
    protected $RKA;

    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;

    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;

    public function __construct(
        PendapatanRepositoryInterface $pendapatan,
        BelanjaRepositoryInterface $belanja,
        PembiayaanRepositoryInterface $pembiayaan,
        UserRepositoryInterface $auth,
        RKARepositoryInterface $RKA,
        OrganisasiRepositoryInterface $organisasi,
        PejabatDesaRepositoryInterface $pejabat
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->pendapatan = $pendapatan;
        $this->belanja = $belanja;
        $this->pembiayaan = $pembiayaan;
        $this->RKA = $RKA;
        $this->organisasi = $organisasi;
        $this->pejabat = $pejabat;
    }

    /**
     * List data pendapatan, belanja
     * pengeluaran
     *
     * return to View : rka.data-rka
     */
    public function index()
    {
        $pendapatan = $this->RKA->findRKAPendapatan($this->auth->getOrganisasiId());
        $belanja = $this->RKA->findRKABelanja($this->auth->getOrganisasiId());
        $pembiayaan = $this->RKA->findRKAPembiayaan($this->auth->getOrganisasiId());

        $this->view('rka.data-rka', [
            'pendapatan' => $pendapatan,
            'belanja'    => $belanja,
            'pembiayaan' => $pembiayaan,
        ]);

    }

    /**
     * Set dpa kemudian jika sukses
     * Redirect::to index
     *
     * @param $id
     * @param $cmd
     * @return mixed
     */
    public function setDPA($id, $cmd)
    {
        // todo : redirect akan disederhankan lagi
        switch ($cmd) {
            case 'pendapatan':
                $this->pendapatan->setDPA($id);
                return $this->redirectURLTo('data-rka-desa');
                break;
            case 'belanja':
                $this->belanja->setDPA($id);
                return $this->redirectURLTo('data-rka-desa');
                break;
            case 'pembiayaan':
                $this->pembiayaan->setDPA($id);
                return $this->redirectURLTo('data-rka-desa');
                break;
            default:
        }
    }

    /**
     * @param $id
     * @param $cmd
     * @return mixed
     */
    public function unsetRKA($id, $cmd)
    {
        // todo : redirect akan disederhankan lagi
        switch ($cmd) {
            case 'pendapatan':
                $this->pendapatan->unsetRKA($id);
                return $this->redirectURLTo('data-rka-desa');
                break;
            case 'belanja':
                $this->belanja->unsetRKA($id);
                return $this->redirectURLTo('data-rka-desa');
                break;
            case 'pembiayaan':
                $this->pembiayaan->unsetRKA($id);
                return $this->redirectURLTo('data-rka-desa');
                break;
            default:
        }
    }

    /**
     * @param $id
     * @param $cmd
     * @return mixed
     */
    public function unsetDPA($id, $cmd)
    {
        switch ($cmd) {
            case 'pendapatan':
                $this->pendapatan->unsetDPA($id);
                return $this->redirectURLTo('data-dpa-desa');
                break;
            case 'belanja':
                $this->belanja->unsetDPA($id);
                return $this->redirectURLTo('data-dpa-desa');
                break;
            case 'pembiayaan':
                $this->pembiayaan->unsetDPA($id);
                return $this->redirectURLTo('data-dpa-desa');
                break;
            default:
        }
    }

    /**
     * Method untuk mencetak rka Desa Formulir 1
     * view_dir : rka.data-rka
     *
     * @return mixed
     */
    public function formulir1()
    {

        $pendapatan = $this->RKA->findRKAPendapatan($this->auth->getOrganisasiId());
        $belanja = $this->RKA->findRKABelanja($this->auth->getOrganisasiId());
        $pembiayaan = $this->RKA->findRKAPembiayaan($this->auth->getOrganisasiId());
        $jumlahPendapatan = $this->RKA->getSumPendapatan($this->auth->getOrganisasiId());
        $jumlahBelanja = $this->RKA->getSumBelanja($this->auth->getOrganisasiId());
        $jumlahPembiayaan = $this->RKA->getSumPembiayaan($this->auth->getOrganisasiId());
        $total = $jumlahPendapatan + $jumlahBelanja + $jumlahPembiayaan;

        // data umum Organisasi
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        // get nama pejabat desa penanda tangan dokumen rka Formulir1
        // dengan @param string $fungsi, default untuk formulir
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');

        // tanggal sekarang
        $tgl = $this->dateIndonesia(date('Y-m-d'));

        $pdf = \App::make('dompdf');

        $pdf->loadView('rka.rka-formulir-1', [
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
        ]);
        $random = str_random(10);
        $file = 'data-rka-formulir-1-' . $tgl . '-' . $random . '.pdf';
        return $pdf->setPaper('a4')->setOrientation('portrait')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formulir2()
    {
        $pendapatan = $this->RKA->findRKAPendapatan($this->auth->getOrganisasiId());
        $jumlahPendapatan = $this->RKA->getSumPendapatan($this->auth->getOrganisasiId());
        // data umum Organisasi
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        // get nama pejabat desa penanda tangan dokumen rka Formulir1
        // dengan @param string $fungsi, default untuk formulir
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        // tanggal sekarang
        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rka.rka-formulir-2', [
            'organisasi'     => $organisasi,
            'pendapatan'     => $pendapatan,
            'jml_pendapatan' => $jumlahPendapatan,
            'tgl'            => $tgl,
            'kades'          => $kades,
        ]);
        $random = str_random(10);
        $file = 'data-rka-formulir-2-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('portrait')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formulir3()
    {
        $belanja = $this->RKA->findRKABelanja($this->auth->getOrganisasiId());
        $jumlahPendapatan = $this->RKA->getSumBelanja($this->auth->getOrganisasiId());
        // data umum Organisasi
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        // get nama pejabat desa penanda tangan dokumen rka Formulir1
        // dengan @param string $fungsi, default untuk formulir
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');

        // tanggal sekarang
        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rka.rka-formulir-3', [
            'organisasi'     => $organisasi,
            'belanja'        => $belanja,
            'jml_pendapatan' => $jumlahPendapatan,
            'tgl'            => $tgl,
            'kades'          => $kades,
        ]);
        $random = str_random(10);
        $file = 'data-rka-formulir-3-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('portrait')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formulir4()
    {
        $belanja = $this->RKA->findRKABelanja($this->auth->getOrganisasiId());
        $jumlahBelanja = $this->RKA->getSumBelanja($this->auth->getOrganisasiId());
        // data umum Organisasi
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());

        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');

        // tanggal sekarang
        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rka.rka-formulir-3', [
            'organisasi'  => $organisasi,
            'belanja'     => $belanja,
            'jml_belanja' => $jumlahBelanja,
            'tgl'         => $tgl,
            'kades'       => $kades,
        ]);
        $random = str_random(10);
        $file = 'data-rka-formulir-2-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('portrait')->stream($file);
    }
}