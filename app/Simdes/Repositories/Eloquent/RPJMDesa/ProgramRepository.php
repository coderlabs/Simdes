<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 18:31
 */

namespace Simdes\Repositories\Eloquent\RPJMDesa;

use Illuminate\Support\Facades\Auth;
use Simdes\Models\Akun\Kelompok;
use Simdes\Models\RPJMDesa\Program;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\ProgramRepositoryInterface;
use Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface;
use Simdes\Services\Forms\RPJMDesa\ProgramEditForm;
use Simdes\Services\Forms\RPJMDesa\ProgramForm;

/**
 * Class ProgramRepository
 *
 * @package Simdes\Repositories\Eloquent\RPJMDesa
 */
class ProgramRepository extends AbstractRepository implements ProgramRepositoyInterface
{
    /**
     * @var \Simdes\Repositories\Kewenangan\ProgramRepositoryInterface
     */
    private $progamKewenangan;

    /**
     * @param Program                    $program
     * @param ProgramRepositoryInterface $progamKewenangan
     */
    public function __construct(Program $program, ProgramRepositoryInterface $progamKewenangan)
    {
        $this->model = $program;
        $this->progamKewenangan = $progamKewenangan;
    }

    /**
     * Menampilkan data list program
     * sesuai dengan masalah_id
     *
     * @param $term
     * @param $masalah_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $masalah_id, $organisasi_id)
    {
        return $this->model
            ->FullTextSearch($term)
            ->where('masalah_id', '=', $masalah_id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->with('program')
            ->remember(2)
            ->paginate(10);
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($term, $organisasi_id)
    {
        return $this->model
            ->FullTextSearch($term)
            ->where('organisasi_id', '=', $organisasi_id)
            ->with('program')
            ->remember(2)
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $program = $this->getNew();
        $program_id = $data['program_id'];
        $sumber_dana_id = $data['sumber_dana_id'];
        $pejabat_desa_id = $data['pejabat_desa_id'];

        $program->user_id = $data['user_id'];
        $program->organisasi_id = $data['organisasi_id'];
        $program->rpjmdesa_id = $data['rpjmdesa_id'];
        $program->masalah_id = $data['masalah_id'];
        $program->program_id = $program_id;
        $program->program = $this->getProgram($program_id);
        $program->lokasi = e($data['lokasi']);
        $program->sasaran = e($data['sasaran']);
        $program->waktu = e($data['waktu']);
        $program->target = e($data['target']);
        $program->sifat = e($data['sifat']);
        $program->tujuan = e($data['tujuan']);
        $program->pagu_anggaran = e($data['pagu_anggaran']);

        // inject string sumberdana dari tabel tb_akun_kelompok
        // saat ini masih memakai tabel tb_sumber_dana_id
        $program->sumber_dana_id = $sumber_dana_id;
        $program->sumber_dana = $this->getStringSumberDana($sumber_dana_id);
        // inject string penanggung jawab dari tb_pejabat_desa
        $program->pejabat_desa_id = $pejabat_desa_id;
        $program->penanggung_jawab = $this->getStringPejabatDesa($pejabat_desa_id);

        $program->save();

        return $program;
    }

    /**
     * mendapatkan string dari program
     * untuk diinputkan ke rpjmdesa
     *
     * @param $program_id
     * @return mixed
     */
    public function getProgram($program_id)
    {
        $getProgram = $this->progamKewenangan->findById($program_id);

        return $getProgram->program;
    }

    /**
     * Get string Sumber dana, ini sifatnya hanya sementara
     * kemudian jika migrasi sudah sampai titik ini maka
     * akan diganti dengan yang baru
     *
     * @param $sumber_dana_id
     *
     * @return mixed
     */
    public function getStringSumberDana($sumber_dana_id)
    {
        $data = Kelompok::find($sumber_dana_id);

        return $data->kelompok;
    }

    /**
     * Get string Pejabat Desa, ini sifatnya hanya sementara
     * kemudian jika migrasi sudah sampai titik ini maka
     * akan diganti dengan yang sudah advanced yeh!!
     *
     * @param $pejabat_desa_id
     *
     * @return mixed
     */
    public function getStringPejabatDesa($pejabat_desa_id)
    {
        $data = \PejabatDesa::find($pejabat_desa_id);

        return $data->nama;
    }

    /**
     * Menampilkan data prgoram yang telah diRPJMDesa kan
     * akan ditampilkan di RKPDesa outpurnya ada tiga
     * rpjmdesa_id|id|program
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function getListProgram($organisasi_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->remember(2)
            ->get([
                'rpjmdesa_id',
                'program_id as id',
                'program',
                'lokasi',
                'waktu',
                'sasaran',
                'tujuan',
                'target',
                'pagu_anggaran',
                'sumber_dana_id',
            ]);
    }

    /**
     * @param Program $program
     * @param array   $data
     *
     * @return Program
     */
    public function update(Program $program, array $data)
    {
        $program_id = $data['program_id'];
        $sumber_dana_id = $data['sumber_dana_id'];
        $pejabat_desa_id = $data['pejabat_desa_id'];

        $program->user_id = $data['user_id'];
        $program->rpjmdesa_id = $data['rpjmdesa_id'];
        $program->masalah_id = $data['masalah_id'];
        $program->program_id = $program_id;
        $program->program = $this->getProgram($program_id);
        $program->lokasi = e($data['lokasi']);
        $program->sasaran = e($data['sasaran']);
        $program->waktu = e($data['waktu']);
        $program->target = e($data['target']);
        $program->sifat = e($data['sifat']);
        $program->tujuan = e($data['tujuan']);
        $program->pagu_anggaran = e($data['pagu_anggaran']);

        // inject string sumberdana dari tabel tb_akun_kelompok
        // saat ini masih memakai tabel tb_sumber_dana_id
        $program->sumber_dana_id = $sumber_dana_id;
        $program->sumber_dana = $this->getStringSumberDana($sumber_dana_id);
        // inject string penanggung jawab dari tb_pejabat_desa
        $program->pejabat_desa_id = $pejabat_desa_id;
        $program->penanggung_jawab = $this->getStringPejabatDesa($pejabat_desa_id);

        $program->save();

        return $program;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $program = $this->findById($id);
        $program->delete();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $masalah_id
     * @return mixed
     */
    public function findByMasalahId($masalah_id)
    {
        return $this->model
            ->where('masalah_id', '=', $masalah_id)
            ->remember(2)
            ->get();
    }

    /**
     * @param $id
     * @param $organisasi_id
     * @return mixed
     */
    public function findByOrganisasi_id($id, $organisasi_id)
    {
        return $this->model
            ->where('id', '=', $id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->first();
    }

    /**
     * @return ProgramForm
     */
    public function getCreationForm()
    {
        return new ProgramForm();
    }

    /**
     * @return ProgramEditForm
     */
    public function getEditForm()
    {
        return new ProgramEditForm();
    }

    /**
     * Get list program diakses oleh RKPDesa
     * untuk ditampilkan dalam dropdown
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function findProgramList($organisasi_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->remember(10)
            ->get(['rpjmdesa_id', 'program_id as id', 'program']);
    }


    /**
     * Method mengecek apakah program sudah pernah
     * dipilih oleh organisasi, program hanya
     * boleh dipilih 1 oleh tiap organisasi
     *
     * @param $organisasi_id
     * @param $program_id
     *
     * @return mixed
     */
    public function isProgramUsedByUserId($organisasi_id, $program_id)
    {
        return $this->model
            ->where('program_id', '=', $program_id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->get();
    }

    /**
     * todo:delete
     * @param $organisasi_id
     * @return mixed
     */
    public function findforCetak($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get();
    }

    /**
     * Get data berdasarkan sumber_dana_id = 7
     * diambil dari tabel akun_kelompok_1
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir1($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->where('sumber_dana_id', '=', '7')->get();
    }

    /**
     * Get data berdasarkan sumber_dana_id = 1
     * diambil dari tabel akun_kelompok_1
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir2($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->where('sumber_dana_id', '=', '1')->get();
    }

    /**
     * Get data berdasarkan sumber_dana_id = 5
     * diambil dari tabel akun_kelompok_1
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir3($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->where('sumber_dana_id', '=', '5')->get();
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir4($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get();
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir5($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get();
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir6($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get();
    }
}