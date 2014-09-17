<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 10:24
 */

namespace RKPDesa;

use RKA\RKAController;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\RKPDesa\RKPDesaRepositoryInterface;
use Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class CetakRKPDesa
 * @package RKPDesa
 */
class CetakRKPDesa extends \BaseController
{

    /**
     * @var \RKA\RKAController
     */
    public $rka;

    /**
     * @var
     */
    protected $pdf;
    /**
     * @var \Simdes\Repositories\RKPDesa\RKPDesaRepositoryInterface
     */
    protected $RKPDesa;
    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;
    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;

    /**
     * @var \Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface
     */
    protected $program;

    /**
     * @param ProgramRepositoyInterface $program
     * @param UserRepositoryInterface $auth
     * @param RKPDesaRepositoryInterface $RKPDesa
     * @param OrganisasiRepositoryInterface $organisasi
     * @param PejabatDesaRepositoryInterface $pejabat
     * @param RKAController $rka
     */
    public function __construct(
        ProgramRepositoyInterface $program,
        UserRepositoryInterface $auth,
        RKPDesaRepositoryInterface $RKPDesa,
        OrganisasiRepositoryInterface $organisasi,
        PejabatDesaRepositoryInterface $pejabat,
        RKAController $rka
    )
    {
        parent::__construct();

        $this->RKPDesa = $RKPDesa;
        $this->auth = $auth;
        $this->organisasi = $organisasi;
        $this->pejabat = $pejabat;
        $this->rka = $rka;
        $this->program = $program;
    }

    /**
     * @return mixed
     */
    public function cetakFormulir1()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $program = $this->RKPDesa->cetakFormulir1($this->auth->getOrganisasiId());

        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rkpdesa.formulir-satu', [
            'organisasi' => $organisasi,
            'program'    => $program,
            'kades'      => $kades,
        ]);
        $random = str_random(10);
        $file = 'RKPDesa-formulir-1-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir2()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $program = $this->RKPDesa->cetakFormulir1($this->auth->getOrganisasiId());

        // pengelompokan berdasarkan sumber dana
        // 1 : Alokasi APBN
        // 2 : Bantuan Keuangan APBD Provinsi
        // 3 : Bantuan Keuangan APBD Kab/Kota
        // 4 : Pendapatan Asli Desa (PADesa)
        // 5 : Dana Bagi Hasil (ADD)
        // 6 : Dana Alokasi Khusus

        $apbn = $this->RKPDesa->danaAPBN($this->auth->getOrganisasiId());
        $apbdProv = $this->RKPDesa->apbProv($this->auth->getOrganisasiId());
        $apbdKab = $this->RKPDesa->apbKab($this->auth->getOrganisasiId());
        $apbDesa = $this->RKPDesa->apbDesa($this->auth->getOrganisasiId());
        $swasta = $this->RKPDesa->swasta($this->auth->getOrganisasiId());

        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rkpdesa.formulir-dua', [
            'organisasi' => $organisasi,
            'apbn'       => $apbn,
            'apbdProv'   => $apbdProv,
            'apbdKab'    => $apbdKab,
            'apbDesa'    => $apbDesa,
            'swasta'     => $swasta,
            'kades'      => $kades,
            'tgl'        => $tgl,
        ]);

        $random = str_random(10);
        $file = 'RKPDesa-formulir-2-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir3()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $camat = $this->pejabat->getCamat($this->auth->getOrganisasiId());
        // pengelompokan berdasarkan sumber dana
        // 1 : Alokasi APBN
        // 2 : Bantuan Keuangan APBD Provinsi
        // 3 : Bantuan Keuangan APBD Kab/Kota
        // 4 : Pendapatan Asli Desa (PADesa)
        // 5 : Dana Bagi Hasil (ADD)
        // 6 : Dana Alokasi Khusus

        $apbn = $this->RKPDesa->danaAPBN($this->auth->getOrganisasiId());
        $apbdProv = $this->RKPDesa->apbProv($this->auth->getOrganisasiId());
        $apbdKab = $this->RKPDesa->apbKab($this->auth->getOrganisasiId());
        $apbDesa = $this->RKPDesa->apbDesa($this->auth->getOrganisasiId());
        $swasta = $this->RKPDesa->swasta($this->auth->getOrganisasiId());

        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rkpdesa.formulir-tiga', [
            'organisasi' => $organisasi,
            'apbn'       => $apbn,
            'apbdProv'   => $apbdProv,
            'apbdKab'    => $apbdKab,
            'apbDesa'    => $apbDesa,
            'swasta'     => $swasta,
            'camat'      => $camat,
            'tgl'        => $tgl,
        ]);

        $random = str_random(10);
        $file = 'RKPDesa-formulir-2-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir4()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $bupati = $this->pejabat->getBupati($this->auth->getOrganisasiId());

        // pengelompokan berdasarkan sumber dana
        // 1 : Alokasi APBN
        // 2 : Bantuan Keuangan APBD Provinsi
        // 3 : Bantuan Keuangan APBD Kab/Kota
        // 4 : Pendapatan Asli Desa (PADesa)
        // 5 : Dana Bagi Hasil (ADD)
        // 6 : Dana Alokasi Khusus

        $apbn = $this->RKPDesa->danaAPBN($this->auth->getOrganisasiId());
        $apbdProv = $this->RKPDesa->apbProv($this->auth->getOrganisasiId());
        $apbdKab = $this->RKPDesa->apbKab($this->auth->getOrganisasiId());
        $apbDesa = $this->RKPDesa->apbDesa($this->auth->getOrganisasiId());
        $swasta = $this->RKPDesa->swasta($this->auth->getOrganisasiId());

        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rkpdesa.formulir-empat', [
            'organisasi' => $organisasi,
            'apbn'       => $apbn,
            'apbdProv'   => $apbdProv,
            'apbdKab'    => $apbdKab,
            'apbDesa'    => $apbDesa,
            'swasta'     => $swasta,
            'bupati'     => $bupati,
            'tgl'        => $tgl,
        ]);

        $random = str_random(10);
        $file = 'RKPDesa-formulir-2-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }
}