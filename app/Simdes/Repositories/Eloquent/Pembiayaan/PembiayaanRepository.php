<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/12/2014
 * Time: 19:25
 */

namespace Simdes\Repositories\Eloquent\Pembiayaan;


use Simdes\Models\Pembiayaan\Pembiayaan;
use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface;
use Simdes\Services\Forms\Pembiayaan\PembiayaanEditForm;
use Simdes\Services\Forms\Pembiayaan\PembiayaanForm;

/**
 * Class PembiayaanRepository
 *
 * @package Simdes\Repositories\Eloquent\Pembiayaan
 */
class PembiayaanRepository extends AbstractRepository implements PembiayaanRepositoryInterface
{

    /**
     * @var
     */
    public $getNamaPembiayaan;
    /**
     * @var
     */
    public $getJumlah;
    /**
     * @var
     */
    private $kelompok;
    /**
     * @var
     */
    private $jenis;
    /**
     * @var
     */
    private $obyek;
    /**
     * @var
     */
    private $rincianObyek;

    /**
     * @param Pembiayaan $pembiayaan
     * @param KelompokRepositoryInterface $kelompok
     * @param JenisRepositoryInterface $jenis
     * @param ObyekRepositoryInterface $obyek
     * @param RincianObyekRepositoryInterface $rincianObyek
     */
    public function __construct(
        Pembiayaan $pembiayaan,
        KelompokRepositoryInterface $kelompok,
        JenisRepositoryInterface $jenis,
        ObyekRepositoryInterface $obyek,
        RincianObyekRepositoryInterface $rincianObyek
    )
    {
        $this->model = $pembiayaan;
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
        $pembiayaan = $this->model->orderBy('tahun', 'desc')
            ->where('pembiayaan', 'LIKE', '%' . $term . '%')
            ->where('organisasi_id', '=', $organisasi_id)
            ->paginate(10);

        return $pembiayaan;
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $pembiayaan = $this->getNew();

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
        $pembiayaan->tahun = e($data['tahun']);
        $pembiayaan->user_id = e($data['user_id']);
        $pembiayaan->organisasi_id = e($data['organisasi_id']);
        $pembiayaan->kelompok_id = e($kelompok_id);
        $pembiayaan->jenis_id = e($jenis_id);
        $pembiayaan->obyek_id = e($obyek_id);
        $pembiayaan->rincian_obyek_id = e($rincian_obyek_id);
        $pembiayaan->volume_1 = e($data['volume_1']);
        $pembiayaan->volume_2 = e($data['volume_2']);
        $pembiayaan->volume_3 = e($data['volume_3']);
        $pembiayaan->satuan_1 = e(ucfirst(strtolower($data['satuan_1'])));
        $pembiayaan->satuan_2 = e(ucfirst(strtolower($data['satuan_2'])));
        $pembiayaan->satuan_3 = e(ucfirst(strtolower($data['satuan_3'])));
        $pembiayaan->pembiayaan = $this->getNamaPembiayaan($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $pembiayaan->jumlah = $this->getJumlah($vol1, $vol2, $vol3, $harga_satuan);
        $pembiayaan->satuan_harga = $harga_satuan;
        $pembiayaan->save();

        return $pembiayaan;
    }

    /**
     * @param $kelompok_id
     * @param $jenis_id
     * @param $obyek_id
     * @param $rincian_obyek_id
     *
     * @return mixed
     */
    public function getNamaPembiayaan($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id)
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
     * @param Pembiayaan $pembiayaan
     * @param array $data
     *
     * @return Pembiayaan
     */
    public function update(Pembiayaan $pembiayaan, array $data)
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
        $pembiayaan->tahun = e($data['tahun']);
        $pembiayaan->user_id = e($data['user_id']);
        $pembiayaan->kelompok_id = e($kelompok_id);
        $pembiayaan->jenis_id = e($jenis_id);
        $pembiayaan->obyek_id = e($obyek_id);
        $pembiayaan->rincian_obyek_id = e($rincian_obyek_id);
        $pembiayaan->volume_1 = e($data['volume_1']);
        $pembiayaan->volume_2 = e($data['volume_2']);
        $pembiayaan->volume_3 = e($data['volume_3']);
        $pembiayaan->satuan_1 = e(ucfirst(strtolower($data['satuan_1'])));
        $pembiayaan->satuan_2 = e(ucfirst(strtolower($data['satuan_2'])));
        $pembiayaan->satuan_3 = e(ucfirst(strtolower($data['satuan_3'])));
        $pembiayaan->pembiayaan = $this->getNamaPembiayaan($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $pembiayaan->jumlah = $this->getJumlah($vol1, $vol2, $vol3, $harga_satuan);
        $pembiayaan->satuan_harga = $harga_satuan;
        $pembiayaan->save();

        return $pembiayaan;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $pembiayaan = $this->findById($id);
        $pembiayaan->delete();
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
     * @return PembiayaanForm
     */
    public function getCreationForm()
    {
        return new PembiayaanForm();
    }

    /**
     * @return PembiayaanEditForm
     */
    public function getEditForm()
    {
        return new PembiayaanEditForm();
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
    public function getCountPembiayaan($organisasi_id)
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
        $pembiayaan = $this->findById($id);
        $pembiayaan->realisasi = $pembiayaan->jumlah - $data['count_jumlah'];
        $pembiayaan->save();

        return $pembiayaan;
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
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get();
    }

    public function getTotPembiayaan($organisasi_id, $kelompok_id = null)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->where('kelompok_id', '=', $kelompok_id)
            ->sum('jumlah');
    }
}