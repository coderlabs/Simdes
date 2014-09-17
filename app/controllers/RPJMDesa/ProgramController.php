<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 18:49
 */

namespace RPJMDesa;

use Barryvdh\DomPDF\PDF;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface;
use Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class ProgramController
 *
 * @package controllers\RPJMDesa
 */
class ProgramController extends \BaseController
{

    /**
     * @var \Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface
     */
    protected $program;

    /**
     * @var \Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface
     */
    protected $masalah;

    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;

    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;

    /**
     * @var \Barryvdh\DomPDF\PDF
     */
    protected $pdf;

    /**
     * @param ProgramRepositoyInterface $program
     * @param MasalahRepositoryInterface $masalah
     * @param UserRepositoryInterface $auth
     * @param OrganisasiRepositoryInterface $organisasi
     * @param PejabatDesaRepositoryInterface $pejabat
     */
    function __construct(
        ProgramRepositoyInterface $program,
        MasalahRepositoryInterface $masalah,
        UserRepositoryInterface $auth,
        OrganisasiRepositoryInterface $organisasi,
        PejabatDesaRepositoryInterface $pejabat
    )
    {
        parent::__construct();

        $this->program = $program;
        $this->masalah = $masalah;
        $this->auth = $auth;
        $this->organisasi = $organisasi;
        $this->pejabat = $pejabat;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->redirectURLTo('data-rpjmdesa');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->masalah->findByFilter($id, $this->auth->getOrganisasiId());

        if ($data == null) {
            return $this->redirectURLTo('data-rpjmdesa');
        } else {
            $this->view('rpjmdesa.data-program', compact('data'));
        }
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        $masalah_id = $this->input('masalah_id');

        return $this->program->findAll($term, $masalah_id, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->program->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'masalah_id'      => $message->first('masalah_id'),
                    'program_id'      => $message->first('program_id'),
                    'lokasi'          => $message->first('lokasi'),
                    'sasaran'         => $message->first('sasaran'),
                    'waktu'           => $message->first('waktu'),
                    'target'          => $message->first('target'),
                    'sifat'           => $message->first('sifat'),
                    'tujuan'          => $message->first('tujuan'),
                    'pagu_anggaran'   => $message->first('pagu_anggaran'),
                    'sumber_dana_id'  => $message->first('sumber_dana_id'),
                    'pejabat_desa_id' => $message->first('pejabat_desa_id')
                ],
            ];
        }
        $data = $form->getInputData();
        $program_id = $data['program_id'];

        // cek dahulu program apakah pernah dipilih sebelumnya oleh user_id
        // yang sama, jika ada result maka akan kembalikan return ke view
        // jika belum maka teruskan eksekusi program dan simpan database
        $cekProgram = $this->program->isProgramUsedByUserId($this->auth->getOrganisasiId(), $program_id);

        if (!count($cekProgram) == 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Program sudah pernah dipilih, tidak boleh dipilih lagi. Silahkan pilih program yang lain!'
            ];
        }

        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->program->create($data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil disimpan.',
        ];

    }

    /**
     * @param $id
     *
     * @return array
     */
    public function edit($id)
    {
        return $this->program->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $program = $this->program->findById($id);
        $form = $this->program->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'masalah_id'      => $message->first('masalah_id'),
                    'program_id'      => $message->first('program_id'),
                    'lokasi'          => $message->first('lokasi'),
                    'sasaran'         => $message->first('sasaran'),
                    'waktu'           => $message->first('waktu'),
                    'target'          => $message->first('target'),
                    'sifat'           => $message->first('sifat'),
                    'tujuan'          => $message->first('tujuan'),
                    'pagu_anggaran'   => $message->first('pagu_anggaran'),
                    'sumber_dana_id'  => $message->first('sumber_dana_id'),
                    'pejabat_desa_id' => $message->first('pejabat_desa_id')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->program->update($program, $data);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil diupdate.'
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        $this->program->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir1()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $program = $this->program->cetakFormulir1($this->auth->getOrganisasiId());
        $judul = "PERENCANAAN PEMBANGUNAN DESA YANG DIBIAYAI SWADAYA MASYARAKAT DAN PIHAK KETIGA";


        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rpjmdesa.cetak-rpjmdesa', [
            'organisasi' => $organisasi,
            'program'    => $program,
            'tgl'        => $tgl,
            'judul'      => $judul,
            'kades'      => $kades,
        ]);
        $random = str_random(10);
        $file = 'RPJMDesa-formulir-1-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir2()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $program = $this->program->cetakFormulir2($this->auth->getOrganisasiId());
        $judul = "PERENCANAAN PEMBANGUNAN DESA YANG ADA DANANYA TAHUN " . date('Y');

        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rpjmdesa.cetak-rpjmdesa', [
            'organisasi' => $organisasi,
            'program'    => $program,
            'tgl'        => $tgl,
            'judul'      => $judul,
            'kades'      => $kades,
        ]);
        $random = str_random(10);
        $file = 'RPJMDesa-formulir-2-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir3()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $program = $this->program->cetakFormulir3($this->auth->getOrganisasiId());
        $judul = "AGENDA PADUAN ANTARA SWADAYA DAN DANA YANG SUDAH ADA TUGAS PEMBANTU";

        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rpjmdesa.cetak-rpjmdesa', [
            'organisasi' => $organisasi,
            'program'    => $program,
            'tgl'        => $tgl,
            'judul'      => $judul,
            'kades'      => $kades,
        ]);
        $random = str_random(10);
        $file = 'RPJMDesa-formulir-2-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir4()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $program = $this->program->cetakFormulir4($this->auth->getOrganisasiId());

        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rpjmdesa.formulir-empat', [
            'organisasi' => $organisasi,
            'program'    => $program,
            'tgl'        => $tgl,
            'kades'      => $kades,
        ]);
        $random = str_random(10);
        $file = 'RPJMDesa-formulir-4-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cetakFormulir6()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $program = $this->program->cetakFormulir6($this->auth->getOrganisasiId());

        $tgl = $this->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');
        $pdf->loadView('rpjmdesa.formulir-enam', [
            'organisasi' => $organisasi,
            'program'    => $program,
            'tgl'        => $tgl,
            'kades'      => $kades,
        ]);
        $random = str_random(10);
        $file = 'RPJMDesa-formulir-6-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->stream($file);
    }
}