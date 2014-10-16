<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 11:37
 */

namespace RPJMDesa;

use RKA\RKAController;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface;
use Simdes\Repositories\RPJMDesa\PemetaanRepositoryInterface;
use Simdes\Repositories\RPJMDesa\PotensiRepositoryInterface;
use Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface;
use Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class MasalahController
 *
 * @package RPJMDesa
 */
class MasalahController extends \BaseController
{

    /**
     * @var \RKA\RKAController
     */
    public $rka;
    /**
     * @var \Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface
     */
    protected $masalah;

    protected $potensi;

    protected $pemetaan;

    protected $prograam;


    /**
     * @var \Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface
     */
    protected $RPJMDesa;
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

    function __construct(
        MasalahRepositoryInterface $masalah,
        RPJMDesaRepositoryInterface $RPJMDesa,
        UserRepositoryInterface $auth,
        OrganisasiRepositoryInterface $organisasi,
        PejabatDesaRepositoryInterface $pejabat,
        RKAController $rka,
        PotensiRepositoryInterface $potensi,
        ProgramRepositoyInterface $program,
        PemetaanRepositoryInterface $pemetaan

    )
    {
        parent::__construct();

        $this->masalah = $masalah;
        $this->RPJMDesa = $RPJMDesa;
        $this->organisasi = $organisasi;
        $this->pejabat = $pejabat;
        $this->rka = $rka;
        $this->auth = $auth;
        $this->potensi = $potensi;
        $this->pemetaan = $pemetaan;
        $this->prograam = $program;
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
        $data = $this->RPJMDesa->findByFilter($id, $this->auth->getOrganisasiId());
        $result = $this->masalah->findAll($term = null, $id, $this->auth->getOrganisasiId());

        if (is_null($data)) {
            return $this->redirectURLTo('data-rpjmdesa');
        } else {
            $this->view('rpjmdesa.data-masalah', compact('data', 'result'));
        }
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function detil($id)
    {
        $data = $this->masalah->findByFilter($id, $this->auth->getOrganisasiId());

        if ($data == null) {
            return $this->redirectURLTo('data-rpjmdesa');
        } else {

            $data_potensi = $this->potensi->findByMasalahId($id);
            $data_pemetaan = $data->pemetaan;
            $data_program = $this->prograam->findByMasalahId($id);

            $no_potensi = 1;

            $this->view('rpjmdesa.detil-masalah', [
                'data'          => $data,
                'data_potensi'  => $data_potensi,
                'data_pemetaan' => $data_pemetaan,
                'data_program'  => $data_program,
                'no_potensi'    => $no_potensi
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $term = $this->input('term');
        $rpjmdesa_id = $this->input('rpjmdesa_id');

        return $this->masalah->findAll($term, $rpjmdesa_id, $this->auth->getOrganisasiId());
    }

    /**
     * @return array
     */
    public function store()
    {
        $form = $this->masalah->getCreationForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'visi' => $message->first('visi')
                ],
            ];

        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $data['organisasi_id'] = $this->auth->getOrganisasiId();
        $this->masalah->create($data);

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
        return $this->masalah->findById($id);
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function update($id)
    {
        $masalah = $this->masalah->findById($id);
        $form = $this->masalah->getEditForm();

        if (!$form->isValid()) {
            $message = $form->getErrors();

            return [
                'Status'     => 'Validation',
                'validation' => [
                    'misi' => $message->first('misi')
                ]
            ];
        }

        $data = $form->getInputData();
        $data['user_id'] = $this->auth->getUserId();
        $this->masalah->update($masalah, $data);

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
        $this->masalah->delete($id);

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }

    /**
     * @return mixed
     */
    public function cetakFormulir5()
    {
        $organisasi = $this->organisasi->findById($this->auth->getOrganisasiId());
        $kades = $this->pejabat->getPejabat($this->auth->getOrganisasiId(), $fungsi = 'kades');
        $masalah = $this->masalah->cetakFormulir5($this->auth->getOrganisasiId());

        $tgl = $this->rka->dateIndonesia(date('Y-m-d'));
        $pdf = \App::make('dompdf');

        // memperhatikan Case Sensitive di shared hosting
        // semua file di folder view adalah huruf kecil
        $pdf->loadView('rpjmdesa.formulir-lima', [
            'organisasi' => $organisasi,
            'masalah'    => $masalah,
            'tgl'        => $tgl,
            'kades'      => $kades,
        ]);
        $random = str_random(10);
        $file = 'RPJMDesa-formulir-1-' . $tgl . '-' . $random . '.pdf';

        return $pdf->setPaper('a4')->setOrientation('landscape')->download($file);
    }

}