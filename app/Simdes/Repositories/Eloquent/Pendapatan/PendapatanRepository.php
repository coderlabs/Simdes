<?php

namespace Simdes\Repositories\Eloquent\Pendapatan;

use Simdes\Models\Pendapatan\Pendapatan;
use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface;
use Simdes\Services\Forms\Pendapatan\PendapatanEditForm;
use Simdes\Services\Forms\Pendapatan\PendapatanForm;
use Simdes\Services\Forms\Pendapatan\PendapatanHistoryForm;


/**
 * Class PendapatanRepository
 *
 * @package Simdes\Repositories\Eloquent\Pendapatan
 */
class PendapatanRepository extends AbstractRepository implements PendapatanRepositoryInterface
{
    /**
     * @var
     */
    public $getNamaPendapatan;
    /**
     * @var
     */
    public $getJumlah;
    /**
     * @var \Simdes\Repositories\Akun\KelompokRepositoryInterface
     */
    private $kelompok;
    /**
     * @var \Simdes\Repositories\Akun\JenisRepositoryInterface
     */
    private $jenis;
    /**
     * @var \Simdes\Repositories\Akun\ObyekRepositoryInterface
     */
    private $obyek;
    /**
     * @var \Simdes\Repositories\Akun\RincianObyekRepositoryInterface
     */
    private $rincianObyek;

    /**
     * @param Pendapatan $pendapatan
     * @param KelompokRepositoryInterface $kelompok
     * @param JenisRepositoryInterface $jenis
     * @param ObyekRepositoryInterface $obyek
     * @param RincianObyekRepositoryInterface $rincianObyek
     */
    public function __construct(Pendapatan $pendapatan,
                                KelompokRepositoryInterface $kelompok,
                                JenisRepositoryInterface $jenis,
                                ObyekRepositoryInterface $obyek,
                                RincianObyekRepositoryInterface $rincianObyek)
    {
        $this->model = $pendapatan;
        $this->kelompok = $kelompok;
        $this->jenis = $jenis;
        $this->obyek = $obyek;
        $this->rincianObyek = $rincianObyek;
    }


    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        $pendapatan = $this->model
            ->orderBy('tahun', 'desc')
            ->where('pendapatan', 'LIKE', '%' . $term . '%')
            ->where('organisasi_id', '=', $organisasi_id)
            ->paginate(10);

        return $pendapatan;
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        $pendapatan = $this->getNew();

        // olah data
        $kelompok_id = (empty($data['kelompok_id'])) ? '0' : $data['kelompok_id'];
        $jenis_id = (empty($data['jenis_id'])) ? '0' : $data['jenis_id'];
        $obyek_id = (empty($data['obyek_id'])) ? '0' : $data['obyek_id'];
        // olah data jumlah
        $vol1 = (empty($data['volume_1'])) ? '1' : $data['volume_1'];
        $vol2 = (empty($data['volume_2'])) ? '1' : $data['volume_2'];
        $vol3 = (empty($data['volume_3'])) ? '1' : $data['volume_3'];
        $harga_satuan = e($data['satuan_harga']);

        $rincian_obyek_id = (empty($data['rincian_obyek_id'])) ? '0' : $data['rincian_obyek_id'];
        $pendapatan->tahun = e($data['tahun']);
        $pendapatan->user_id = e($data['user_id']);
        $pendapatan->organisasi_id = e($data['organisasi_id']);
        $pendapatan->kelompok_id = e($kelompok_id);
        $pendapatan->jenis_id = e($jenis_id);
        $pendapatan->obyek_id = e($obyek_id);
        $pendapatan->rincian_obyek_id = e($rincian_obyek_id);
        $pendapatan->volume_1 = e($data['volume_1']);
        $pendapatan->volume_2 = e($data['volume_2']);
        $pendapatan->volume_3 = e($data['volume_3']);
        $pendapatan->satuan_1 = e(ucfirst(strtolower($data['satuan_1'])));
        $pendapatan->satuan_2 = e(ucfirst(strtolower($data['satuan_2'])));
        $pendapatan->satuan_3 = e(ucfirst(strtolower($data['satuan_3'])));
        $pendapatan->pendapatan = $this->getNamaPendapatan($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $pendapatan->kode_rekening = $this->getKodeRekening($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $pendapatan->jumlah = $this->getJumlah($vol1, $vol2, $vol3, $harga_satuan);
        $pendapatan->satuan_harga = $harga_satuan;
        $pendapatan->save();

        return $pendapatan;
    }

    /**
     * @param $kelompok_id
     * @param $jenis_id
     * @param $obyek_id
     * @param $rincian_obyek_id
     *
     * @return mixed
     */
    public function getNamaPendapatan($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id)
    {
        if (!empty($rincian_obyek_id)) {
            $getNamaPendapatan = $this->rincianObyek->findById($rincian_obyek_id);

            return $getNamaPendapatan->rincian_obyek;
        } elseif (!empty($obyek_id)) {
            $getNamaPendapatan = $this->obyek->findById($obyek_id);

            return $getNamaPendapatan->obyek;
        } elseif (!empty($jenis_id)) {
            $getNamaPendapatan = $this->jenis->findById($jenis_id);

            return $getNamaPendapatan->jenis;
        } elseif (!empty($kelompok_id)) {
            $getNamaPendapatan = $this->kelompok->findById($kelompok_id);

            return $getNamaPendapatan->kelompok;
        }
    }

    /**
     * @param $kelompok_id
     * @param $jenis_id
     * @param $obyek_id
     * @param $rincian_obyek_id
     * @return mixed
     */
    public function getKodeRekening($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id)
    {
        if (!empty($rincian_obyek_id)) {
            $getKode = $this->rincianObyek->findById($rincian_obyek_id);

            return $getKode->kode_rekening;
        } elseif (!empty($obyek_id)) {
            $getKode = $this->obyek->findById($obyek_id);

            return $getKode->kode_rekening;
        } elseif (!empty($jenis_id)) {
            $getKode = $this->jenis->findById($jenis_id);

            return $getKode->kode_rekening;
        } elseif (!empty($kelompok_id)) {
            $getKode = $this->kelompok->findById($kelompok_id);

            return $getKode->kode_rekening;
        }
    }

    /**
     * @param $vol1
     * @param $vol2
     * @param $vol3
     * @param $harga_satuan
     *
     * @return mixed
     */
    public function getJumlah($vol1, $vol2, $vol3, $harga_satuan)
    {
        return $vol1 * $vol2 * $vol3 * $harga_satuan;
    }

    /**
     * @param Pendapatan $pendapatan
     * @param array $data
     *
     * @return Pendapatan
     */
    public function update(Pendapatan $pendapatan, array $data)
    {
        // olah data
        $kelompok_id = (empty($data['kelompok_id'])) ? '0' : $data['kelompok_id'];
        $jenis_id = (empty($data['jenis_id'])) ? '0' : $data['jenis_id'];
        $obyek_id = (empty($data['obyek_id'])) ? '0' : $data['obyek_id'];
        // olah data jumlah
        $vol1 = (empty($data['volume_1'])) ? '1' : $data['volume_1'];
        $vol2 = (empty($data['volume_2'])) ? '1' : $data['volume_2'];
        $vol3 = (empty($data['volume_3'])) ? '1' : $data['volume_3'];
        $harga_satuan = e($data['satuan_harga']);

        $rincian_obyek_id = (empty($data['rincian_obyek_id'])) ? '0' : $data['rincian_obyek_id'];
        $pendapatan->tahun = e($data['tahun']);
        $pendapatan->user_id = e($data['user_id']);
        $pendapatan->kelompok_id = e($kelompok_id);
        $pendapatan->jenis_id = e($jenis_id);
        $pendapatan->obyek_id = e($obyek_id);
        $pendapatan->rincian_obyek_id = e($rincian_obyek_id);
        $pendapatan->volume_1 = e($data['volume_1']);
        $pendapatan->volume_2 = e($data['volume_2']);
        $pendapatan->volume_3 = e($data['volume_3']);
        $pendapatan->satuan_1 = e(ucfirst(strtolower($data['satuan_1'])));
        $pendapatan->satuan_2 = e(ucfirst(strtolower($data['satuan_2'])));
        $pendapatan->satuan_3 = e(ucfirst(strtolower($data['satuan_3'])));
        $pendapatan->pendapatan = $this->getNamaPendapatan($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $pendapatan->kode_rekening = $this->getKodeRekening($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $pendapatan->jumlah = $this->getJumlah($vol1, $vol2, $vol3, $harga_satuan);
        $pendapatan->satuan_harga = $harga_satuan;
        $pendapatan->save();

        return $pendapatan;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $pendapatan = $this->findById($id);
        $pendapatan->delete();
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
     * @return PendapatanForm
     */
    public function getCreationForm()
    {
        return new PendapatanForm();
    }

    /**
     * @param $id
     *
     * @return PendapatanEditForm
     */
    public function getEditForm()
    {
        return new PendapatanEditForm();
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
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function getCountPendapatan($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->sum('jumlah');
    }


    /**
     * Seting rka Desa
     * jika dalam waktu 7 hari setelah update rka belum disetujui maka secara
     * otomatis status dari rka menjadi dpa
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function setRKA($id)
    {

        $setRKA = $this->findById($id);
        $setRKA->is_rka = 1;
        $setRKA->date_rka = new \DateTime();
        $setRKA->save();

        return $setRKA;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function unsetRKA($id)
    {

        $setRKA = $this->findById($id);
        if ($setRKA) {
            $setRKA->is_rka = 0;
            $setRKA->save();
        } else {
            return 'Data dengan id = ' . $id . ' tidak ditemukan. Indikasi SQl Injection silahkan Log In kembali!';
        }

        return $setRKA;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function setDPA($id)
    {
        $setDPA = $this->findById($id);
        $setDPA->is_dpa = 1;
        $setDPA->save();

        return $setDPA;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function unsetDPA($id)
    {
        $setDPA = $this->findById($id);
        if ($setDPA) {
            $setDPA->is_dpa = 0;
            $setDPA->save();
        } else {
            return 'Data dengan id = ' . $id . ' tidak ditemukan. Indikasi SQl Injection silahkan Log In kembali!';
        }

        return $setDPA;
    }

    /**
     * @param $organisasi_id
     * @return mixed
     */
    public function getList($organisasi_id, $term)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('is_dpa', '=', 1)
            ->where('pendapatan', 'LIKE', '%' . $term . '%')
            ->get(['id', 'pendapatan', 'jumlah', 'realisasi']);
    }

    /**
     * @param $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function realisasiAnggaran($id, array $data)
    {
        $pendapatan = $this->findById($id);
        $pendapatan->realisasi = $pendapatan->jumlah - $data['count_jumlah'];
        $pendapatan->save();

        return $pendapatan;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getText($id)
    {
        $data = $this->findById($id);
        return $data->pendapatan;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getKode($id)
    {
        $data = $this->findById($id);
        return $data->kode_rekening;
    }

    /**
     * @param Pendapatan $pendapatan
     * @param array $data
     * @return Pendapatan
     */
    public function setHistory(Pendapatan $pendapatan, array $data)
    {
        $pendapatan->user_id = e($data['user_id']);
        $pendapatan->januari = e($data['januari']);
        $pendapatan->februari = e($data['februari']);
        $pendapatan->maret = e($data['maret']);
        $pendapatan->april = e($data['april']);
        $pendapatan->mei = e($data['mei']);
        $pendapatan->juni = e($data['juni']);
        $pendapatan->juli = e($data['juli']);
        $pendapatan->agustus = e($data['agustus']);
        $pendapatan->september = e($data['september']);
        $pendapatan->oktober = e($data['oktober']);
        $pendapatan->november = e($data['november']);
        $pendapatan->desember = e($data['desember']);
        $pendapatan->save();

        return $pendapatan;
    }

    /**
     * @return PendapatanHistoryForm
     */
    public function getHistoryForm()
    {
        return new PendapatanHistoryForm();
    }

    /**
     * Find By Organisasi digunakan untuk keperluan cetak
     * rka, dpa dan Perdes APBDesa
     * @todo akan dioptimasi berdasarkan is_rka, is_dpa dan is_perdes
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function findByOrganisasiId($organisasi_id)
    {
        return $this->model->with('kelompok')->where('organisasi_id', '=', $organisasi_id)->get();
    }
}
