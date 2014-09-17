<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 8/8/2014
 * Time: 13:52
 */

namespace Transaksi;


use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\Transaksi\BelanjaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

class LaporanBkuBelanjaController extends \BaseController
{

    private $belanja;
    private $organisasi;
    private $pejabat;

    public function __construct(
        UserRepositoryInterface $auth,
        BelanjaRepositoryInterface $belanja,
        OrganisasiRepositoryInterface $organisasi,
        PejabatDesaRepositoryInterface $pejabat
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->belanja = $belanja;
        $this->organisasi = $organisasi;
        $this->pejabat = $pejabat;
    }


    public function index()
    {
        $this->view('transaksi.bku-belanja');
    }

    public function read()
    {
        $term = $this->input('term');
        $start = $this->input('start');
        $end = $this->input('end');

        // jika start dikosongi maka otomatis akan request tanggal awal bulan ini
        if (empty($start)) {
            $start = new \DateTime('now');
            $start->modify('first day of this month');
            $start = $start->format('Y-m-d');
        }

        // jika end dikosongi maka otomatis akan request tanggal akhir bulan ini
        if (empty($end)) {
            $end = new \DateTime('now');
            $end->modify('last day of this month');
            $end = $end->format('Y-m-d');
        }

        return $this->belanja->findByDate($term, $start, $end, $this->auth->getOrganisasiId());
    }

    public function cetak()
    {

    }

    public function laporan()
    {

    }

    public function cetakBKU()
    {
        $start = $this->input('start');
        $end = $this->input('end');

        // jika start dikosongi maka otomatis akan request tanggal awal bulan ini
        if (empty($start)) {
            $start = new \DateTime('now');
            $start->modify('first day of this month');
            $start = $start->format('Y-m-d');
        }

        // jika end dikosongi maka otomatis akan request tanggal akhir bulan ini
        if (empty($end)) {
            $end = new \DateTime('now');
            $end->modify('last day of this month');
            $end = $end->format('Y-m-d');
        }


        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getKades($this->auth->getOrganisasiId());
        $bendahara = $this->pejabat->getBendahara($this->auth->getOrganisasiId());
        $belanja = $this->belanja->findForBku($start, $end, $this->auth->getOrganisasiId());
        $jml_bln_ini = $this->belanja->jumlahBulanIni($start, $end, $this->auth->getOrganisasiId());
        $jml_sampai_bln_ini = $this->belanja->jumlahSampaiBulanIni($this->auth->getOrganisasiId());
        $jml_sampai_bln_lalu = $jml_sampai_bln_ini - $jml_bln_ini;

        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('transaksi.cetak-bku-belanja', [
            'organisasi'          => $organisasi,
            'belanja'             => $belanja,
            'tgl'                 => $tgl,
            'kades'               => $kades,
            'bendahara'           => $bendahara,
            'jml_bln_ini'         => $jml_bln_ini,
            'jml_sampai_bln_ini'  => $jml_sampai_bln_ini,
            'jml_sampai_bln_lalu' => $jml_sampai_bln_lalu
        ]);
        $random = str_random(10);
        $file = 'BKU-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

} 