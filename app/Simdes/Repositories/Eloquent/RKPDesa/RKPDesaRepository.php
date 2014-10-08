<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/16/2014
 * Time: 18:38
 */

namespace Simdes\Repositories\Eloquent\RKPDesa;

use Simdes\Models\RKPDesa\IndikatorHasil;
use Simdes\Models\RKPDesa\IndikatorKeluaran;
use Simdes\Models\RKPDesa\IndikatorManfaat;
use Simdes\Models\RKPDesa\IndikatorMasukan;
use Simdes\Models\RKPDesa\RKPDesa;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Repositories\RKPDesa\RKPDesaRepositoryInterface;
use Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface;
use Simdes\Services\Forms\RKPDesa\RKPDesaEditForm;
use Simdes\Services\Forms\RKPDesa\RKPDesaForm;

/**
 * Class RKPDesaRepository
 *
 * @package Simdes\Repositories\Eloquent\RKPDesa
 */
class RKPDesaRepository extends AbstractRepository implements RKPDesaRepositoryInterface
{
    /**
     * @var \Simdes\Repositories\RPJMDesa\ProgramRepositoyInterface
     */
    private $program;
    /**
     * @var \Simdes\Models\RKPDesa\IndikatorMasukan
     */
    private $indikatorMasukan;
    /**
     * @var \Simdes\Models\RKPDesa\IndikatorKeluaran
     */
    private $indikatorKeluaran;
    /**
     * @var \Simdes\Models\RKPDesa\IndikatorHasil
     */
    private $indikatorHasil;
    /**
     * @var \Simdes\Models\RKPDesa\IndikatorManfaat
     */
    private $indikatorManfaat;

    /**
     * @var \Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface
     */
    private $kegiatan;


    /**
     * @param RKPDesa $RKPDesa
     * @param ProgramRepositoyInterface $program
     * @param IndikatorMasukan $indikatorMasukan
     * @param IndikatorKeluaran $indikatorKeluaran
     * @param IndikatorHasil $indikatorHasil
     * @param IndikatorManfaat $indikatorManfaat
     * @param KegiatanRepositoryInterface $kegiatan
     */
    public function __construct(RKPDesa $RKPDesa,
                                ProgramRepositoyInterface $program,
                                IndikatorMasukan $indikatorMasukan,
                                IndikatorKeluaran $indikatorKeluaran,
                                IndikatorHasil $indikatorHasil,
                                IndikatorManfaat $indikatorManfaat,
                                KegiatanRepositoryInterface $kegiatan

    )
    {
        $this->model = $RKPDesa;

        $this->program = $program;
        $this->indikatorMasukan = $indikatorMasukan;
        $this->indikatorKeluaran = $indikatorKeluaran;
        $this->indikatorHasil = $indikatorHasil;
        $this->indikatorManfaat = $indikatorManfaat;

        $this->kegiatan = $kegiatan;

    }

    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id, $program_id)
    {
        return $this->model
            ->FullTextSearch($term)
            ->where('organisasi_id', '=', $organisasi_id)
            ->where('program_id', '=', $program_id)
            ->orderBy('id')
            ->paginate(10, ['id', 'kegiatan', 'satuan', 'tahun', 'lokasi', 'waktu', 'pagu_anggaran']);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        // tampung data dalam variable
        $program_id = $data['program_id'];
        $kegiatan_id = $data['kegiatan_id'];
        $sumber_dana_id = $data['sumber_dana_id'];

        $RKPDesa = $this->getNew();

        $RKPDesa->tahun = $data['tahun'];
        $RKPDesa->user_id = $data['user_id'];
        $RKPDesa->program_id = $program_id;
        $RKPDesa->kegiatan_id = $kegiatan_id;
        $RKPDesa->rpjmdesa_id = $data['rpjmdesa_id'];
        $RKPDesa->lokasi = e($data['lokasi']);
        $RKPDesa->tujuan = e($data['tujuan']);
        $RKPDesa->sasaran = e($data['sasaran']);
        $RKPDesa->target = e($data['target']);
        $RKPDesa->pejabat_desa_id = e($data['pejabat_desa_id']);
        $RKPDesa->waktu = e($data['waktu']);
        $RKPDesa->status = e($data['status']);
        $RKPDesa->pagu_anggaran = $data['pagu_anggaran'];
        $RKPDesa->sumber_dana_id = $sumber_dana_id;
        $RKPDesa->organisasi_id = $data['organisasi_id'];

        // input string agar ringan dalam pencarian data dan
        // mengurangi relasi untuk mempercepat load data

        $RKPDesa->program = $this->program->getProgram($program_id);

        // diambil dari tb_kegiatan package dari Kewenagan
        // sementara ini tidak dipakai, nanti jika
        // sudah siap repositorynya akan
        // digunakan untuk inject
        // disable dulu

        $RKPDesa->kegiatan = $this->kegiatan->getStringKegiatan($kegiatan_id);

        $RKPDesa->sumber_dana = $this->program->getStringSumberDana($sumber_dana_id);

        $RKPDesa->save();

        // update table dengan input terlebih dahulu ke tb_indikator_*
        // tujuannya untuk mendapatkan id dari masing2 table
        // input menggunakan function agar rapi dan akan
        // memakai stored prosedure jika mungkin
//        $data = $this->insertIndikator($RKPDesa->id, $RKPDesa->organisasi_id);

        // siapkan data untuk di update ke RKPDesa
//        $up_data = $this->findById($RKPDesa->id);
//        $this->updateRKPDesa($up_data, $data);

        return $RKPDesa;
    }


    /**
     * @param $rkpdesa_id
     * @param $organisasi_id
     *
     * @return array
     */
    public function insertIndikator($rkpdesa_id, $organisasi_id)
    {
        // simpan ke tb_indikator_masukan
        $inMas = $this->indikatorMasukan->create([
            'rkpdesa_id' => $rkpdesa_id,
            'organisasi_id' => $organisasi_id
        ]);


        // simpan ke tb_indikator_masukan
        $inKel = $this->indikatorKeluaran->create([
            'rkpdesa_id' => $rkpdesa_id,
            'organisasi_id' => $organisasi_id
        ]);

        // simpan ke tb_indikator_masukan
        $inHas = $this->indikatorHasil->create([
            'rkpdesa_id' => $rkpdesa_id,
            'organisasi_id' => $organisasi_id
        ]);

        // simpan ke tb_indikator_masukan
        $inMan = $this->indikatorManfaat->create([
            'rkpdesa_id' => $rkpdesa_id,
            'organisasi_id' => $organisasi_id
        ]);

        return $data = [
            'indikator_masukan_id' => $inMas->id,
            'indikator_keluaran_id' => $inKel->id,
            'indikator_hasil_id' => $inHas->id,
            'indikator_manfaat_id' => $inMan->id
        ];
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
     * @param RKPDesa $RKPDesa
     * @param array $data
     *
     * @return RKPDesa
     */
    public function updateRKPDesa(RKPDesa $RKPDesa, array $data)
    {
        $RKPDesa->indikator_masukan_id = $data['indikator_masukan_id'];
        $RKPDesa->indikator_keluaran_id = $data['indikator_keluaran_id'];
        $RKPDesa->indikator_hasil_id = $data['indikator_hasil_id'];
        $RKPDesa->indikator_manfaat_id = $data['indikator_manfaat_id'];

        $RKPDesa->save();

        return $RKPDesa;
    }

    /**
     * @param RKPDesa $RKPDesa
     * @param array $data
     *
     * @return RKPDesa
     */
    public function update(RKPDesa $RKPDesa, array $data)
    {
        // tampung data dalam variable
        $program_id = $data['program_id'];
        $kegiatan_id = $data['kegiatan_id'];
        $sumber_dana_id = $data['sumber_dana_id'];
        $RKPDesa->tahun = $data['tahun'];
        $RKPDesa->user_id = $data['user_id'];
        $RKPDesa->program_id = $program_id;
        $RKPDesa->kegiatan_id = $kegiatan_id;
        $RKPDesa->rpjmdesa_id = $data['rpjmdesa_id'];
        $RKPDesa->lokasi = e($data['lokasi']);
        $RKPDesa->tujuan = e($data['tujuan']);
        $RKPDesa->target = e($data['target']);
        $RKPDesa->pejabat_desa_id = e($data['pejabat_desa_id']);
        $RKPDesa->sasaran = e($data['sasaran']);
        $RKPDesa->waktu = e($data['waktu']);
        $RKPDesa->status = e($data['status']);
        $RKPDesa->pagu_anggaran = $data['pagu_anggaran'];
        $RKPDesa->sumber_dana_id = $sumber_dana_id;

        // input string agar ringan dalam pencarian data dan
        // mengurangi relasi untuk mempercepat load data

        $RKPDesa->program = $this->program->getProgram($program_id);
        $RKPDesa->kegiatan = $this->kegiatan->getStringKegiatan($kegiatan_id);
        $RKPDesa->sumber_dana = $this->program->getStringSumberDana($sumber_dana_id);

        $RKPDesa->save();

        return $RKPDesa;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $RKPDesa = $this->findById($id);
        $RKPDesa->delete();
    }

    /**
     * @return RKPDesaForm
     */
    public function getCreationForm()
    {
        return new RKPDesaForm();
    }

    /**
     * @return RKPDesaEditForm
     */
    public function getEditForm()
    {
        return new RKPDesaEditForm();
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id)
    {
        return $this->model->where('id', '=', $id)->where('organisasi_id', '=', $organisasi_id)->first();
    }

    /**
     * @return mixed
     */
    public function getListKegiatan()
    {
        return $this->model->get(['kegiatan_id as id', 'kegiatan', 'rpjmdesa_id', 'pagu_anggaran']);
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir1($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get();
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir2($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->with('pejabatDesa')->get();
    }

    /**
     * Dikelompokan berdasarkan Sumberdana
     * Alokasi APBN
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function danaAPBN($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('sumber_dana_id', '=', 2)
            ->with('pejabatDesa')->get();
    }

    public function apbProv($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('sumber_dana_id', '=', 13)
            ->with('pejabatDesa')->get();
    }

    public function apbKab($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('sumber_dana_id', '=', 14)
            ->with('pejabatDesa')->get();
    }

    public function apbDesa($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->whereIn('sumber_dana_id', ['1', '3', '4', '8'])
            ->with('pejabatDesa')->get();
    }

    public function swasta($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->whereIn('sumber_dana_id', ['6', '7'])
            ->with('pejabatDesa')->get();
    }

}