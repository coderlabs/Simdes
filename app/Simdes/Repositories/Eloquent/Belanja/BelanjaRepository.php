<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/19/2014
 * Time: 07:16
 */

namespace Simdes\Repositories\Eloquent\Belanja;


use Simdes\Models\Belanja\Belanja;
use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\Belanja\BelanjaRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Services\Forms\Belanja\BelanjaEditForm;
use Simdes\Services\Forms\Belanja\BelanjaForm;
use Simdes\Services\Forms\Belanja\BelanjaHistoryForm;

/**
 * Class BelanjaRepository
 *
 * @package Simdes\Repositories\Eloquent\Belanja
 */
class BelanjaRepository extends AbstractRepository implements BelanjaRepositoryInterface
{

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
     * @var \Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface
     */
    private $kegiatan;


    /**
     * @param Belanja $belanja
     * @param KelompokRepositoryInterface $kelompok
     * @param JenisRepositoryInterface $jenis
     * @param ObyekRepositoryInterface $obyek
     * @param RincianObyekRepositoryInterface $rincianObyek
     * @param KegiatanRepositoryInterface $kegiatan
     */
    public function __construct(Belanja $belanja,
                                KelompokRepositoryInterface $kelompok,
                                JenisRepositoryInterface $jenis,
                                ObyekRepositoryInterface $obyek,
                                RincianObyekRepositoryInterface $rincianObyek,
                                KegiatanRepositoryInterface $kegiatan
    )
    {
        $this->model = $belanja;
        $this->kelompok = $kelompok;
        $this->jenis = $jenis;
        $this->obyek = $obyek;
        $this->rincianObyek = $rincianObyek;
        $this->kegiatan = $kegiatan;
    }

    /**
     * @param $term
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->orderBy('tahun', 'desc')
            ->where('kegiatan', 'LIKE', '%' . $term . '%')
            ->where('organisasi_id', '=', $organisasi_id)
            ->paginate(10);
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
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $belanja = $this->getNew();

        // olah data
        $kelompok_id = (empty($data['kelompok_id'])) ? '0' : $data['kelompok_id'];
        $jenis_id = (empty($data['jenis_id'])) ? '0' : $data['jenis_id'];
        $obyek_id = (empty($data['obyek_id'])) ? '0' : $data['obyek_id'];
        // olah data jumlah
        $vol1 = (empty($data['volume_1'])) ? '1' : $data['volume_1'];
        $vol2 = (empty($data['volume_2'])) ? '1' : $data['volume_2'];
        $vol3 = (empty($data['volume_3'])) ? '1' : $data['volume_3'];
        $harga_satuan = e($data['satuan_harga']);
        $kegiatan_id = e($data['kegiatan_id']);

        $rincian_obyek_id = (empty($data['rincian_obyek_id'])) ? '0' : $data['rincian_obyek_id'];

        $belanja->tahun = e($data['tahun']);
        $belanja->user_id = $data['user_id'];
        $belanja->organisasi_id = $data['organisasi_id'];
        $belanja->kegiatan_id = $kegiatan_id;
        $belanja->kelompok_id = $kelompok_id;
        $belanja->jenis_id = $jenis_id;
        $belanja->obyek_id = $obyek_id;
        $belanja->rincian_obyek_id = $rincian_obyek_id;
        $belanja->volume_1 = e($data['volume_1']);
        $belanja->volume_2 = e($data['volume_2']);
        $belanja->volume_3 = e($data['volume_3']);
        $belanja->satuan_1 = e(ucfirst(strtolower($data['satuan_1'])));
        $belanja->satuan_2 = e(ucfirst(strtolower($data['satuan_2'])));
        $belanja->satuan_3 = e(ucfirst(strtolower($data['satuan_3'])));
        $belanja->belanja = $this->getNamaBelanja($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $belanja->kode_rekening = $this->getKodeRekening($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $belanja->jumlah = $this->getJumlah($vol1, $vol2, $vol3, $harga_satuan);
        $belanja->kegiatan = $this->getKegiatan($kegiatan_id);
        $belanja->rkpdesa_id = $data['rkpdesa_id'];
        $belanja->pagu_anggaran = $data['pagu_anggaran'];
        $belanja->satuan_harga = $harga_satuan;
        $belanja->save();

        return $belanja;
    }

    /**
     * @param $kelompok_id
     * @param $jenis_id
     * @param $obyek_id
     * @param $rincian_obyek_id
     *
     * @return mixed
     */
    public function getNamaBelanja($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id)
    {
        if (!empty($rincian_obyek_id)) {
            $getNamaBelanja = $this->rincianObyek->findById($rincian_obyek_id);

            return $getNamaBelanja->rincian_obyek;
        } elseif (!empty($obyek_id)) {
            $getNamaBelanja = $this->obyek->findById($obyek_id);

            return $getNamaBelanja->obyek;
        } elseif (!empty($jenis_id)) {
            $getNamaBelanja = $this->jenis->findById($jenis_id);

            return $getNamaBelanja->jenis;
        } elseif (!empty($kelompok_id)) {
            $getNamaBelanja = $this->kelompok->findById($kelompok_id);

            return $getNamaBelanja->kelompok;
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
     * @param $kegiatan_id
     *
     * @return mixed
     */
    public function getKegiatan($kegiatan_id)
    {
        $data = $this->kegiatan->findById($kegiatan_id);

        return $data->kegiatan;
    }

    /**
     * @param Belanja $belanja
     * @param array $data
     *
     * @return Belanja
     */
    public function update(Belanja $belanja, array $data)
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
        $kegiatan_id = e($data['kegiatan_id']);

        $rincian_obyek_id = (empty($data['rincian_obyek_id'])) ? '0' : $data['rincian_obyek_id'];

        $belanja->tahun = e($data['tahun']);
        $belanja->user_id = $data['user_id'];
        $belanja->kegiatan_id = $kegiatan_id;
        $belanja->kelompok_id = $kelompok_id;
        $belanja->jenis_id = $jenis_id;
        $belanja->obyek_id = $obyek_id;
        $belanja->rincian_obyek_id = $rincian_obyek_id;
        $belanja->volume_1 = e($data['volume_1']);
        $belanja->volume_2 = e($data['volume_2']);
        $belanja->volume_3 = e($data['volume_3']);
        $belanja->satuan_1 = e(ucfirst(strtolower($data['satuan_1'])));
        $belanja->satuan_2 = e(ucfirst(strtolower($data['satuan_2'])));
        $belanja->satuan_3 = e(ucfirst(strtolower($data['satuan_3'])));
        $belanja->belanja = $this->getNamaBelanja($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $belanja->kode_rekening = $this->getKodeRekening($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $belanja->jumlah = $this->getJumlah($vol1, $vol2, $vol3, $harga_satuan);
        $belanja->kegiatan = $this->getKegiatan($kegiatan_id);
        $belanja->rkpdesa_id = $data['rkpdesa_id'];
        $belanja->pagu_anggaran = $data['pagu_anggaran'];
        $belanja->satuan_harga = $harga_satuan;
        $belanja->save();

        return $belanja;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $belanja = $this->findById($id);
        $belanja->delete();
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
     * @return BelanjaForm
     */
    public function getCreationForm()
    {
        return new BelanjaForm();
    }

    /**
     * @return BelanjaEditForm
     */
    public function getEditForm()
    {
        return new BelanjaEditForm();
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
     * @param $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function realisasiAnggaran($id, array $data)
    {
        $belanja = $this->findById($id);
        $belanja->realisasi = $belanja->jumlah - $data['count_jumlah'];
        $belanja->save();

        return $belanja;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getText($id)
    {
        $data = $this->findById($id);
        return $data->belanja;
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
     * @param $organisasi_id
     * @param $term
     * @return mixed
     */
    public function autocomplete($organisasi_id, $term)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('is_dpa', '=', 1)
            ->where('belanja', 'LIKE', '%' . $term . '%')
            ->get(['id', 'belanja', 'jumlah', 'realisasi']);
    }

    /**
     * @return BelanjaHistoryForm
     */
    public function getHistoryForm()
    {
        return new BelanjaHistoryForm();
    }

    /**
     * @param Belanja $belanja
     * @param array $data
     * @return Belanja
     */
    public function setHistory(Belanja $belanja, array $data)
    {
        $belanja->user_id = e($data['user_id']);
        $belanja->januari = e($data['januari']);
        $belanja->februari = e($data['februari']);
        $belanja->maret = e($data['maret']);
        $belanja->april = e($data['april']);
        $belanja->mei = e($data['mei']);
        $belanja->juni = e($data['juni']);
        $belanja->juli = e($data['juli']);
        $belanja->agustus = e($data['agustus']);
        $belanja->september = e($data['september']);
        $belanja->oktober = e($data['oktober']);
        $belanja->november = e($data['november']);
        $belanja->desember = e($data['desember']);
        $belanja->save();

        return $belanja;
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
        return $this->model
            ->with('kelompok')
            ->where('organisasi_id', '=', $organisasi_id)
            ->get();
    }

    /**
     * Hitung total jumlah (Rp)
     * digunakan pada cetak rka, dpa, Perdes dan tampil data lainnya
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function getCountBelanja($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->sum('jumlah');
    }
}