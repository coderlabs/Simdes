<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:29
 */

namespace Perdes;

use Anouar\Fpdf\Fpdf;
use Simdes\Repositories\Belanja\BelanjaRepositoryInterface;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface;
use Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface;
use Simdes\Repositories\Perdes\BatangTubuhRepositoryInterface;
use Simdes\Repositories\Perdes\DasarHukumRepositoryInterface;
use Simdes\Repositories\Perdes\JudulRepositoryInterface;
use Simdes\Repositories\Perdes\KonsideranRepositoryInterface;
use Simdes\Repositories\Perdes\MateriPokokRepositoryInterface;
use Simdes\Repositories\Perdes\PenutupRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class JudulController
 * @package Perdes
 */
class JudulController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\Perdes\JudulRepositoryInterface
     */
    private $judul;
    /**
     * @var \Simdes\Repositories\Perdes\KonsideranRepositoryInterface
     */
    private $konsideran;
    /**
     * @var \Simdes\Repositories\Perdes\DasarHukumRepositoryInterface
     */
    private $dasarHukum;
    /**
     * @var \Simdes\Repositories\Perdes\BatangTubuhRepositoryInterface
     */
    private $batangTubuh;
    /**
     * @var \Simdes\Repositories\Perdes\PenutupRepositoryInterface
     */
    private $penutup;
    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    private $pejabat;
    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    private $organisasi;
    /**
     * @var \Anouar\Fpdf\Fpdf
     */
    private $fpdf;

    /**
     * @var \Simdes\Repositories\Perdes\MateriPokokRepositoryInterface
     */
    private $materi;

    /**
     * @var PendapatanRepositoryInterface
     */
    private $pendapatan;
    /**
     * @var BelanjaRepositoryInterface
     */
    private $belanja;
    /**
     * @var PembiayaanRepositoryInterface
     */
    private $pembiayaan;

    /**
     * @param Fpdf $fpdf
     * @param UserRepositoryInterface $auth
     * @param JudulRepositoryInterface $judul
     * @param KonsideranRepositoryInterface $konsideran
     * @param DasarHukumRepositoryInterface $dasarHukum
     * @param BatangTubuhRepositoryInterface $batangTubuh
     * @param PenutupRepositoryInterface $penutup
     * @param PejabatDesaRepositoryInterface $pejabat
     * @param OrganisasiRepositoryInterface $organisasi
     * @param MateriPokokRepositoryInterface $materi
     * @param PendapatanRepositoryInterface $pendapatan
     * @param BelanjaRepositoryInterface $belanja
     * @param PembiayaanRepositoryInterface $pembiayaan
     */
    public function __construct(
        Fpdf $fpdf,
        UserRepositoryInterface $auth,
        JudulRepositoryInterface $judul,
        KonsideranRepositoryInterface $konsideran,
        DasarHukumRepositoryInterface $dasarHukum,
        BatangTubuhRepositoryInterface $batangTubuh,
        PenutupRepositoryInterface $penutup,
        PejabatDesaRepositoryInterface $pejabat,
        OrganisasiRepositoryInterface $organisasi,
        MateriPokokRepositoryInterface $materi,
        PendapatanRepositoryInterface $pendapatan,
        BelanjaRepositoryInterface $belanja,
        PembiayaanRepositoryInterface $pembiayaan
    )
    {
        parent::__construct();

        $this->auth = $auth;
        $this->judul = $judul;
        $this->konsideran = $konsideran;
        $this->dasarHukum = $dasarHukum;
        $this->batangTubuh = $batangTubuh;
        $this->penutup = $penutup;
        $this->pejabat = $pejabat;
        $this->organisasi = $organisasi;
        $this->fpdf = $fpdf;
        $this->materi = $materi;
        $this->pendapatan = $pendapatan;
        $this->belanja = $belanja;
        $this->pembiayaan = $pembiayaan;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $this->view('perdes.data-perdes-judul');
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');

        return $this->judul->findAll($term, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->judul->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'jenis'                => $message->first('jenis'),
                    'judul'                => $message->first('judul'),
                    'nomor'                => $message->first('nomor'),
                    'tempat'               => $message->first('tempat'),
                    'tanggal'              => $message->first('tanggal'),
                    'tahun'                => $message->first('tahun'),
                    'pengundangan'         => $message->first('pengundangan'),
                    'tanggal_pengundangan' => $message->first('tanggal_pengundangan'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->judul->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function edit($id)
    {
        return $this->judul->findById($id, $this->auth->getOrganisasiId());
    }

    /**
     * @param $id
     * @return array
     */
    public function update($id)
    {
        $pendapatan = $this->judul->findById($id, $this->auth->getOrganisasiId());
        $form = $this->judul->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();
            return [
                'Status'     => 'Validation',
                'validation' => [
                    'jenis'                => $message->first('jenis'),
                    'judul'                => $message->first('judul'),
                    'nomor'                => $message->first('nomor'),
                    'tempat'               => $message->first('tempat'),
                    'tanggal'              => $message->first('tanggal'),
                    'tahun'                => $message->first('tahun'),
                    'pengundangan'         => $message->first('pengundangan'),
                    'tanggal_pengundangan' => $message->first('tanggal_pengundangan'),
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->judul->update($pendapatan, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.',
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {

        $data = $this->judul->findById($id, $this->auth->getOrganisasiId());

        $konsideran = array_pluck($data->konsideran, 'konsideran');
        $dasar = array_pluck($data->dasarhukum, 'dasar_hukum');
        $batang = array_pluck($data->batangTubuh, 'istilah');

        $pendapatan = $this->pendapatan->findByOrganisasiId($this->auth->getOrganisasiId());
        $belanja = $this->belanja->findByOrganisasiId($this->auth->getOrganisasiId());
        $pembiayaan = $this->pembiayaan->findByOrganisasiId($this->auth->getOrganisasiId());

        $tot_pendapatan = $this->pendapatan->getCountPendapatan($this->auth->getOrganisasiId());
        $tot_belanja = $this->belanja->getCountBelanja($this->auth->getOrganisasiId());
        $tot_pembiayaan = $this->pembiayaan->getCountPembiayaan($this->auth->getOrganisasiId());

        $materi = $this->materi->findByPerdesId($id, $this->auth->getOrganisasiId());

        if (!$data) {
            return $this->redirectURLTo('data-perdes-judul');
        }
        $this->view('perdes.detail-perdes', [
            'data'          => $data,
            'konsideran'    => $konsideran,
            'dasar'         => $dasar,
            'batang'        => $batang,
            'materi'        => $materi,
            'pendapatan'    => $pendapatan,
            'belanja'       => $belanja,
            'pembiayaan'    => $pembiayaan,
            'totPendapatan' => $tot_pendapatan,
            'totBelanja'    => $tot_belanja,
            'totPembiayaan' => $tot_pembiayaan,
        ]);
    }

    /**
     * Cetak Peraturan Desa RPJMDesa
     *
     * @param $id
     * @return mixed
     */
    public function cetakRPJMDesa($id)
    {
        // siapkan data untuk judul
        $data = $this->judul->findById($id, $this->auth->getOrganisasiId());
        // siapkan data desa dan pejabat desa
        $desa = $this->organisasi->getNama($this->auth->getOrganisasiId());
        $dt_kades = $this->pejabat->getKades($this->auth->getOrganisasiId());
        $dt_sekdes = $this->pejabat->getSekdes($this->auth->getOrganisasiId());

        $kades= null;
        $sekdes = null;

        if (is_null($dt_kades)) {
            $kades = $dt_kades;
        }

        if (is_null($dt_sekdes)) {
            $sekdes = $dt_sekdes;
        }

        // siapkan materi
        $materi = $this->materi->findByPerdesId($id, $this->auth->getOrganisasiId());

        // tanggal saat ini dengan format 21 Januari 2014
        $date = $this->dateIndonesia(date('Y-m-d'));

        //siapkan data konsideran, dasar hukum dan batang tubuh
        // @todo optimasi akan evaluasi dan dihapus
        $konsideran = array_pluck($data->konsideran, 'konsideran');
        $dasar = array_pluck($data->dasarhukum, 'dasar_hukum');

        $this->pdfRPHMDesa($konsideran, $dasar, $desa, $data, $kades, $sekdes, $date, $materi);
    }

    /**
     * Method untuk generate pdf dengan FPDF
     * Generate pdf Peraturan Desa RPJMDesa
     * output live preview di stream
     *
     * @param $konsideran
     * @param $dasar
     * @param $desa
     * @param $data
     * @param $kades
     * @param $sekdes
     * @param $date
     * @param $materi
     */
    public function pdfRPHMDesa($konsideran, $dasar, $desa, $data, $kades, $sekdes, $date, $materi)
    {
        // antiipasi jika data kosong

        $random = str_random(10);
        $this->fpdf = New PDF();

        $this->fpdf->AddPage('P', 'a4');
        $this->fpdf->SetAuthor('Aplikasi Simdes | <edicyber@gmail.com>');
        $this->fpdf->SetTitle('Peraturan Desa RPJMDesa ' . $desa . ' Tanggal Cetak ' . $date . '-' . $random . ' ');
        $this->fpdf->SetCreator('Dokumen ini di Generate oleh Aplikasi Simdes | <edicyber@gmail.com>');
        $this->fpdf->SetMargins(20, 15, 15);
        $this->fpdf->Image(public_path() . '/img/pancasila.png', 95, 10, 0, 20);
        $this->fpdf->Ln(25);
        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->Cell(0, 10, 'PEMERINTAH DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'PERATURAN DESA ' . strtoupper($desa), '', '', 'C');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'Nomor : ' . strtoupper($data->nomor) . ' TAHUN ' . strtoupper($data->tahun), '', '', 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'TENTANG', '', '', 'C');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, strtoupper($data->judul), '', '', 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'DENGAN RAHMAT TUHAN YANG MAHA ESA', '', '', 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'KEPALA DESA ' . strtoupper($desa), '', '', 'C');

        #Content Konsideran
        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(25, 7, 'Menimbang', '', '', 'J');
        $this->fpdf->Cell(5, 7, ':');

        $data_konsideran = (count($konsideran) > 0) ? $konsideran[0] : 'Belum diset';

        $no = 'a';
        $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
        $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $data_konsideran));
        if (count($konsideran) > 1) {
            for ($i = 1; $i < count($konsideran); $i++) {
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
                $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $konsideran[$i]));
            }
        }

        #Content Dasar Hukum
        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(25, 7, 'Mengingat', '', '', 'J');
        $this->fpdf->Cell(5, 7, ':');

        $data_dasar = (count($dasar) > 0) ? $dasar[0] : 'Belum diset';
        $no = '1';
        $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
        $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $data_dasar));
        if (count($dasar) > 1) {
            for ($i = 1; $i < count($dasar); $i++) {
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
                $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $dasar[$i]));
            }
        }

        if ($this->fpdf->y > 240) {
            $this->fpdf->AddPage();
        } else {
            $this->fpdf->Ln(10);
        }

        # static content
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(0, 10, 'Dengan Persetujuan Bersama', '', '', 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'BADAN PERMUSYAWARATAN DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(0, 10, 'dan', '', '', 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'KEPALA DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'MEMUTUSKAN :', '', '', 'C');

        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(25, 5, 'Menetapkan', '', '', 'J');
        $this->fpdf->Cell(10, 5, ':');
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->MultiCell(0, 5, 'PERATURAN DESA TENTANG ' . strtoupper($data->judul));

        foreach ($materi as $data_materi) {
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', 11);
            $this->fpdf->Cell(0, 10, $data_materi->bab, '', '', 'C');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(0, 10, $data_materi->judul, '', '', 'C');
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->Cell(0, 10, $data_materi->pasal, '', '', 'C');
            $this->fpdf->Ln(15);
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $data_materi->uraian), '', 'J');
            $this->fpdf->Ln(7);
            $no = '1';
            foreach ($data_materi->poin as $poin) {
                $this->fpdf->SetFont('Arial', '', 11);
                $this->fpdf->Cell(10, 7, $no++ . '.', '', '', 'J');
                $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $poin->poin));
            }
        }

        // khusus tanda tangan jika y lebih dari 160 maka ke halaman baru
        if ($this->fpdf->y > 150) {
            $this->fpdf->AddPage();
        }

        $tempat = $data->tempat;

        $this->fpdf->Ln(10);
        $this->fpdf->Cell(100);
        $this->fpdf->Cell(25, 10, 'Ditetapkan di', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(0, 10, ucfirst($tempat), '', '', 'L');

        $tanggal = $this->dateIndonesia($data->tanggal);

        $this->fpdf->Ln(7);
        $this->fpdf->Cell(100);
        $this->fpdf->Cell(25, 10, 'pada Tanggal', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(0, 10, $tanggal, '', '', 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(90);
        $this->fpdf->Cell(72, 10, 'KEPALA DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(30);
        $this->fpdf->Cell(90);
        $this->fpdf->Cell(72, 10, ucwords($kades), '', '', 'C');
        $this->fpdf->SetFont('Arial', '', 11);


        $this->fpdf->Ln(10);
        $this->fpdf->Cell(30, 10, 'Diundangkan di', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(20, 10, ucfirst($tempat), '', '', 'L');

        $tgl_pengundangan = $this->dateIndonesia($data->tanggal_pengundangan);

        $this->fpdf->Ln(7);
        $this->fpdf->Cell(30, 10, 'pada Tanggal', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(20, 10, $tgl_pengundangan, '', '', 'L');

        $nama_sekdes = (isset($sekdes)) ? $sekdes : 'Belum diset';

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(60, 10, 'Sekretaris Desa ' . ucwords($desa), '', '', 'C');
        $this->fpdf->Ln(30);
        $this->fpdf->Cell(60, 10, ucwords($nama_sekdes), '', '', 'C');
        $this->fpdf->SetFont('Arial', '', 11);

        $pengundangan = $data->pengundangan;
        $tahun = $data->tahun;
        $nomor = $data->nomor;


        $this->fpdf->Ln(10);
        $this->fpdf->Cell(60, 10, strtoupper($pengundangan) . ' ' . strtoupper($desa), '', '', 'L');
        $this->fpdf->Cell(25, 10, 'TAHUN ' . $tahun, '', '', 'L');
        $this->fpdf->Cell(25, 10, 'NOMOR ' . $nomor, '', '', 'L');


        $this->fpdf->Output('Perdes Desa ' . $desa . ' Tanggal ' . $date . '-' . $random . '.pdf', 'I');
        exit;
    }

    /**
     * Cetak Peraturan Desa APBDesa
     *
     * @param $id
     */
    public function cetakAPBDesa($id)
    {
        // siapkan data untuk judul
        $data = $this->judul->findById($id, $this->auth->getOrganisasiId());
        // siapkan data desa dan pejabat desa
        $desa = $this->organisasi->getNama($this->auth->getOrganisasiId());
        $dt_kades = $this->pejabat->getKades($this->auth->getOrganisasiId());
        $dt_sekdes = $this->pejabat->getSekdes($this->auth->getOrganisasiId());

        $kades= null;
        $sekdes = null;

        if (is_null($dt_kades)) {
            $kades = $dt_kades;
        }

        if (is_null($dt_sekdes)) {
            $sekdes = $dt_sekdes;
        }
        // siapkan materi
        $materi = $this->materi->findByPerdesId($id, $this->auth->getOrganisasiId());

        // tanggal saat ini dengan format 21 Januari 2014
        $date = $this->dateIndonesia(date('Y-m-d'));

        //siapkan data konsideran, dasar hukum dan batang tubuh
        // @todo optimasi akan evaluasi dan dihapus
        $konsideran = array_pluck($data->konsideran, 'konsideran');
        $dasar = array_pluck($data->dasarhukum, 'dasar_hukum');

        // siapkan data pendapatan, belanja dan pembiayaan
        $pendapatan = $this->pendapatan->findByOrganisasiId($this->auth->getOrganisasiId());
        $belanja = $this->belanja->findByOrganisasiId($this->auth->getOrganisasiId());
        $pembiayaan = $this->pembiayaan->findByOrganisasiId($this->auth->getOrganisasiId());

        // siapkan data total jumlah pendapatan, belanja dan pembiayaan
        $tot_pendapatan = $this->pendapatan->getCountPendapatan($this->auth->getOrganisasiId());
        $tot_belanja = $this->belanja->getCountBelanja($this->auth->getOrganisasiId());
        $tot_pembiayaan = $this->pembiayaan->getCountPembiayaan($this->auth->getOrganisasiId(), $kelompok_id = 11);
        $totPenerimaanPembiayaan = $this->pembiayaan->getTotPembiayaan($this->auth->getOrganisasiId(), $kelompok_id = 11);
        $totPengeluaranPembiayaan = $this->pembiayaan->getTotPembiayaan($this->auth->getOrganisasiId(), $kelompok_id = 12);

        $this->pdfAPBDesa($konsideran, $dasar, $desa, $data, $kades, $sekdes, $date, $materi, $pendapatan, $belanja, $pembiayaan, $tot_pendapatan, $tot_belanja, $tot_pembiayaan, $totPenerimaanPembiayaan, $totPengeluaranPembiayaan);
    }

    /**
     * Method untuk generate pdf dengan FPDF
     * Generate pdf Peraturan Desa APBDesa
     * output live preview di stream
     *
     * @param $konsideran
     * @param $dasar
     * @param $desa
     * @param $data
     * @param $kades
     * @param $sekdes
     * @param $date
     * @param $materi
     */
    public function pdfAPBDesa($konsideran, $dasar, $desa, $data, $kades, $sekdes, $date, $materi, $pendapatan, $belanja, $pembiayaan, $tot_pendapatan, $tot_belanja, $tot_pembiayaan, $totPenerimaanPembiayaan, $totPengeluaranPembiayaan)
    {
        // antiipasi jika data kosong

        $random = str_random(10);
        $this->fpdf = New PDF();

        $this->fpdf->AddPage('P', 'a4');
        $this->fpdf->SetAuthor('Aplikasi Simdes | <edicyber@gmail.com>');
        $this->fpdf->SetTitle('Peraturan Desa APBDesa ' . $desa . ' Tanggal Cetak ' . $date . '-' . $random . ' ');
        $this->fpdf->SetCreator('Dokumen ini di Generate oleh Aplikasi Simdes | <edicyber@gmail.com>');
        $this->fpdf->SetMargins(20, 15, 15);
        $this->fpdf->Image(public_path() . '/img/pancasila.png', 95, 10, 0, 20);
        $this->fpdf->Ln(25);
        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->Cell(0, 10, 'PEMERINTAH DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'PERATURAN DESA ' . strtoupper($desa), '', '', 'C');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'Nomor : ' . strtoupper($data->nomor) . ' TAHUN ' . strtoupper($data->tahun), '', '', 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'TENTANG', '', '', 'C');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, strtoupper($data->judul), '', '', 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'DENGAN RAHMAT TUHAN YANG MAHA ESA', '', '', 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'KEPALA DESA ' . strtoupper($desa), '', '', 'C');

        #Content Konsideran
        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(25, 7, 'Menimbang', '', '', 'J');
        $this->fpdf->Cell(5, 7, ':');

        $data_konsideran = (count($konsideran) > 0) ? $konsideran[0] : 'Belum diset';

        $no = 'a';
        $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
        $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $data_konsideran));
        if (count($konsideran) > 1) {
            for ($i = 1; $i < count($konsideran); $i++) {
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
                $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $konsideran[$i]));
            }
        }

        #Content Dasar Hukum
        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(25, 7, 'Mengingat', '', '', 'J');
        $this->fpdf->Cell(5, 7, ':');

        $data_dasar = (count($dasar) > 0) ? $dasar[0] : 'Belum diset';
        $no = '1';
        $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
        $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $data_dasar));
        if (count($dasar) > 1) {
            for ($i = 1; $i < count($dasar); $i++) {
                $this->fpdf->Cell(30);
                $this->fpdf->Cell(5, 7, $no++ . '.', '', '', 'J');
                $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $dasar[$i]));
            }
        }

        if ($this->fpdf->y > 260) {
            $this->fpdf->AddPage();
        } else {
            $this->fpdf->Ln(10);
        }

        # static content
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(0, 10, 'Dengan Persetujuan Bersama', '', '', 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'BADAN PERMUSYAWARATAN DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(0, 10, 'dan', '', '', 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'KEPALA DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(0, 10, 'MEMUTUSKAN :', '', '', 'C');

        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(25, 5, 'Menetapkan', '', '', 'J');
        $this->fpdf->Cell(10, 5, ':');
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->MultiCell(0, 5, 'PERATURAN DESA TENTANG ' . strtoupper($data->judul));

        // pasal 1 ini khusus static
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->Cell(0, 10, 'Pasal 1', '', '', 'C');
        $this->fpdf->Ln(15);
        $this->fpdf->SetFont('Arial', '', 11);
        $this->fpdf->MultiCell(0, 7, 'Anggaran Pendapatan dan Belanja Daerah Tahun ' . $data->tahun . ' Anggaran sebagai berikut :', '', 'J');
        $this->fpdf->Ln(7);

        // pendapatan
        $this->fpdf->Cell(100, 5, '1. Pendapatan', '', '', 'J');
        $this->fpdf->Cell(10, 5, 'Rp.', '', '', 'R');
        $this->fpdf->Cell(30, 5, number_format($tot_pendapatan, '2', ',', '.'), '', '', 'R');
        $this->fpdf->Ln(7);
        // belanja
        $this->fpdf->Cell(100, 5, '2. Belanja', '', '', 'J');
        $this->fpdf->Cell(10, 5, 'Rp.', '', '', 'R');
        $this->fpdf->Cell(30, 5, number_format($tot_belanja, '2', ',', '.'), '', '', 'R');
        $this->fpdf->Ln(2);
        $this->fpdf->Cell(102);
        $this->fpdf->Cell(40, 5, '___________________ (-)', '', '', 'L');
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(20);
        // hitung dulu pendapatan - belanja
        $selisih = $tot_pendapatan - $tot_belanja;
        $this->fpdf->Cell(80, 5, 'Surplus/(Defisit)', '', '', 'J');
        $this->fpdf->Cell(10, 5, 'Rp.', '', '', 'R');
        $this->fpdf->Cell(30, 5, number_format($selisih, '2', ',', '.'), '', '', 'R');

        // pembiayaan
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(70, 5, '3. Pembiayaan', '', '', 'J');
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(5);
        $this->fpdf->Cell(95, 5, 'a. Penerimaan', '', '', 'J');
        $this->fpdf->Cell(10, 5, 'Rp.', '', '', 'R');
        $this->fpdf->Cell(30, 5, number_format($totPenerimaanPembiayaan, '2', ',', '.'), '', '', 'R');
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(5);
        $this->fpdf->Cell(95, 5, 'b. Pengeluaran', '', '', 'J');
        $this->fpdf->Cell(10, 5, 'Rp.', '', '', 'R');
        $this->fpdf->Cell(30, 5, number_format($totPengeluaranPembiayaan, '2', ',', '.'), '', '', 'R');
        $this->fpdf->Ln(2);
        $this->fpdf->Cell(102);
        $this->fpdf->Cell(40, 5, '___________________ (-)', '', '', 'L');
        $this->fpdf->Ln(7);

        // hitung selisih pembiayaan
        $selisih_pembiayaan = $totPenerimaanPembiayaan - $totPengeluaranPembiayaan;

        $this->fpdf->Cell(20);
        $this->fpdf->Cell(80, 5, 'Pembiayaan Netto', '', '', 'J');
        $this->fpdf->Cell(10, 5, 'Rp.', '', '', 'R');
        $this->fpdf->Cell(30, 5, number_format($selisih_pembiayaan, '2', ',', '.'), '', '', 'R');
        $this->fpdf->Ln(7);

        $this->fpdf->Cell(100, 5, 'Sisa Lebih Pembiayaan Anggaran tahun Berkenaan :', '', '', 'J');
        $this->fpdf->Cell(10, 5, 'Rp.', '', '', 'R');
        $this->fpdf->Cell(30, 5, number_format($selisih_pembiayaan, '2', ',', '.'), '', '', 'R');
        $this->fpdf->Ln(7);

        // pasal 2 rincian mengenai pendapatan sebagaimana pasal 1
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(0, 10, 'Pasal 2', '', '', 'C');
        $this->fpdf->Ln(15);

        // berdasarkan kelompok_id pendapatan  = 1
        $this->fpdf->Cell(10, 7, '(1)');
        $this->fpdf->MultiCell(0, 7, 'Pendapatan Asli Desa sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 1) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id pendapatan  = 2
        $this->fpdf->Cell(10, 7, '(2)');
        $this->fpdf->MultiCell(0, 7, 'Alokasi APBN sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 2) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id pendapatan  = 3
        $this->fpdf->Cell(10, 7, '(3)');
        $this->fpdf->MultiCell(0, 7, 'Bagian Hasil Pajak dan Retribusi Daerah sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 3) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id pendapatan  = 4
        $this->fpdf->Cell(10, 7, '(4)');
        $this->fpdf->MultiCell(0, 7, 'Bagian Dana Perimbangan Pusat dan Daerah sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 4) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id pendapatan  = 5
        $this->fpdf->Cell(10, 7, '(5)');
        $this->fpdf->MultiCell(0, 7, 'Bantuan Keuangan Pemerintah Provinsi, Kabupaten/Kota, dan desa lainnya sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 5) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id pendapatan  = 6
        $this->fpdf->Cell(10, 7, '(6)');
        $this->fpdf->MultiCell(0, 7, 'Hibah sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 6) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id pendapatan  = 7
        $this->fpdf->Cell(10, 7, '(7)');
        $this->fpdf->MultiCell(0, 7, 'Sumbangan Pihak Ketiga sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 7) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id pendapatan  = 8
        $this->fpdf->Cell(10, 7, '(8)');
        $this->fpdf->MultiCell(0, 7, 'Lain-lain Pendapatan Asli Desa yang Sah sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($pendapatan as $dtPendapatan) {
            if ($dtPendapatan->kelompok_id == 8) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPendapatan->pendapatan . '  sejumlah Rp. ' . number_format($dtPendapatan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // pasal 3 rincian mengenai belanja sebagaimana pasal 1
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(0, 10, 'Pasal 3', '', '', 'C');
        $this->fpdf->Ln(15);

        // belanja langusng dan tidak langsung
        $this->fpdf->Cell(10, 7, '(1)');
        $this->fpdf->MultiCell(0, 7, 'Belanja sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');

        // @todo jumlah belanja langsung dan tidak langsung dibedakan
        $this->fpdf->Cell(10, 7, '');
        $this->fpdf->MultiCell(0, 7, 'a. Belanja tidak langsung sejumlah Rp. ' . number_format($tot_belanja, '2', ',', '.') . '', 'J');
        $this->fpdf->Cell(10, 7, '');
        $this->fpdf->MultiCell(0, 7, 'b. Belanja langsung sejumlah Rp. ' . number_format($tot_belanja, '2', ',', '.') . '', 'J');

        // berdasarkan kelompok_id belanja  = 9
        $this->fpdf->Cell(10, 7, '(2)');
        $this->fpdf->MultiCell(0, 7, 'Belanja Tidak Langsung sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($belanja as $dtBelanja) {
            if ($dtBelanja->kelompok_id == 9) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtBelanja->belanja . '  sejumlah Rp. ' . number_format($dtBelanja->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // berdasarkan kelompok_id belanja  = 10
        $this->fpdf->Cell(10, 7, '(3)');
        $this->fpdf->MultiCell(0, 7, 'Belanja Langsung sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');
        $na = 'a';
        foreach ($belanja as $dtBelanja) {
            if ($dtBelanja->kelompok_id == 10) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtBelanja->belanja . '  sejumlah Rp. ' . number_format($dtBelanja->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        // pasal 4 rincian mengenai belanja sebagaimana pasal 1
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(0, 10, 'Pasal 4', '', '', 'C');
        $this->fpdf->Ln(15);

        // pembiayaan
        $this->fpdf->Cell(10, 7, '(1)');
        $this->fpdf->MultiCell(0, 7, 'Pembiayaan sebagaimana yang dimaksud Pasal 1 terdiri dari :', '', 'J');

        // @todo jumlah belanja langsung dan tidak langsung dibedakan
        $this->fpdf->Cell(10, 7, '');
        $this->fpdf->MultiCell(0, 7, 'a. Penerimaan sejumlah Rp. ' . number_format($totPenerimaanPembiayaan, '2', ',', '.') . '', 'J');
        $this->fpdf->Cell(10, 7, '');
        $this->fpdf->MultiCell(0, 7, 'b. Pengeluaran sejumlah Rp. ' . number_format($totPengeluaranPembiayaan, '2', ',', '.') . '', 'J');

        $this->fpdf->Cell(10, 7, '(2)');
        $this->fpdf->MultiCell(0, 7, 'Penerimaan sebagaimana yang dimaksud pada ayat (1) huruf a terdiri dari jenis pembiayaan terdiri dari :', '', 'J');
        foreach ($pembiayaan as $dtPembiayaan) {
            if ($dtPembiayaan->kelompok_id == 11) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPembiayaan->pembiayaan . '  sejumlah Rp. ' . number_format($dtPembiayaan->jumlah, '2', ',', '.') . '', 'J');
            }
        }

        $this->fpdf->Cell(10, 7, '(3)');
        $this->fpdf->MultiCell(0, 7, 'Penerimaan sebagaimana yang dimaksud pada ayat (1) huruf b terdiri dari jenis pembiayaan terdiri dari :', '', 'J');
        foreach ($pembiayaan as $dtPembiayaan) {
            if ($dtPembiayaan->kelompok_id == 12) {
                $this->fpdf->Cell(10, 7, '');
                $this->fpdf->MultiCell(0, 7, $na++ . '. ' . $dtPembiayaan->pembiayaan . '  sejumlah Rp. ' . number_format($dtPembiayaan->jumlah, '2', ',', '.') . '', 'J');
            }
        }


        foreach ($materi as $data_materi) {
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', 'B', 11);
            $this->fpdf->Cell(0, 10, $data_materi->bab, '', '', 'C');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(0, 10, $data_materi->judul, '', '', 'C');
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->Cell(0, 10, $data_materi->pasal, '', '', 'C');
            $this->fpdf->Ln(15);
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $data_materi->uraian), '', 'J');
            $this->fpdf->Ln(7);
            $no = '1';
            foreach ($data_materi->poin as $poin) {
                $this->fpdf->SetFont('Arial', '', 11);
                $this->fpdf->Cell(10, 7, $no++ . '.', '', '', 'J');
                $this->fpdf->MultiCell(0, 7, str_replace('&quot;', '"', $poin->poin));
            }
        }

        // khusus tanda tangan jika y lebih dari 160 maka ke halaman baru
        if ($this->fpdf->y > 150) {
            $this->fpdf->AddPage();
        }

        $tempat = $data->tempat;

        $this->fpdf->Cell(100);
        $this->fpdf->Cell(25, 10, 'Ditetapkan di', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(0, 10, ucfirst($tempat), '', '', 'L');

        $tanggal = $this->dateIndonesia($data->tanggal);

        $this->fpdf->Ln(7);
        $this->fpdf->Cell(100);
        $this->fpdf->Cell(25, 10, 'pada Tanggal', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(0, 10, $tanggal, '', '', 'L');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(90);
        $this->fpdf->Cell(72, 10, 'KEPALA DESA ' . strtoupper($desa), '', '', 'C');
        $this->fpdf->Ln(30);
        $this->fpdf->Cell(90);
        $this->fpdf->Cell(72, 10, ucwords($kades), '', '', 'C');
        $this->fpdf->SetFont('Arial', '', 11);


        $this->fpdf->Ln(10);
        $this->fpdf->Cell(30, 10, 'Diundangkan di', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(20, 10, ucfirst($tempat), '', '', 'L');

        $tgl_pengundangan = $this->dateIndonesia($data->tanggal_pengundangan);

        $this->fpdf->Ln(7);
        $this->fpdf->Cell(30, 10, 'pada Tanggal', '', '', 'L');
        $this->fpdf->Cell(4, 10, ':', '', '', 'L');
        $this->fpdf->Cell(20, 10, $tgl_pengundangan, '', '', 'L');

        $nama_sekdes = (isset($sekdes)) ? $sekdes : 'Belum diset';

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', 'B', 11);
        $this->fpdf->Cell(60, 10, 'Sekretaris Desa ' . ucwords($desa), '', '', 'C');
        $this->fpdf->Ln(30);
        $this->fpdf->Cell(60, 10, ucwords($nama_sekdes), '', '', 'C');
        $this->fpdf->SetFont('Arial', '', 11);

        $pengundangan = $data->pengundangan;
        $tahun = $data->tahun;
        $nomor = $data->nomor;


        $this->fpdf->Ln(10);
        $this->fpdf->Cell(60, 10, strtoupper($pengundangan) . ' ' . strtoupper($desa), '', '', 'L');
        $this->fpdf->Cell(25, 10, 'TAHUN ' . $tahun, '', '', 'L');
        $this->fpdf->Cell(25, 10, 'NOMOR ' . $nomor, '', '', 'L');


        $this->fpdf->Output('Perdes Desa APBDesa' . $desa . ' Tanggal ' . $date . '-' . $random . '.pdf', 'I');
        exit;
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        $this->judul->delete($id, $this->auth->getOrganisasiId());

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.',
        ];
    }


}

/**
 * Claas untuk generate Waternark
 * dan memutar watermark
 *
 * Class PDF_Rotate
 * @package Perdes
 */
class PDF_Rotate extends FPDF
{
    /**
     * @var int
     */
    var $angle = 0;

    /**
     * @param $angle
     * @param $x
     * @param $y
     */
    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    /**
     *
     */
    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}

/**
 * Class PDF
 * @package Perdes
 */
class PDF extends PDF_Rotate
{
    /**
     *
     */
    function Header()
    {
        //Put the watermark
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->RotatedText(65, 190, 'P E L A T I H A N', 45);
    }

    /**
     * @param $x
     * @param $y
     * @param $txt
     * @param $angle
     */
    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}