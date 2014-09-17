<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/19/2014
 * Time: 07:16
 */

namespace Simdes\Repositories\Eloquent\Belanja;


use Simdes\Models\Belanja\Belanja;
use Simdes\Models\Belanja\RencanaBelanja;
use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\Akun\RincianObyekRepositoryInterface;
use Simdes\Repositories\Belanja\BelanjaRencanaRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface;
use Simdes\Services\Forms\Belanja\BelanjaEditForm;
use Simdes\Services\Forms\Belanja\BelanjaForm;
use Simdes\Services\Forms\Belanja\BelanjaRencanaEditForm;
use Simdes\Services\Forms\Belanja\BelanjaRencanaForm;

/**
 * Class BelanjaRepository
 *
 * @package Simdes\Repositories\Eloquent\Belanja
 */
class BelanjaRencanaRepository extends AbstractRepository implements BelanjaRencanaRepositoryInterface
{

    /**
     * @var \Simdes\Repositories\Akun\KelompokRepositoryInterface
     */
    protected $kelompok;

    /**
     * @var \Simdes\Repositories\Akun\JenisRepositoryInterface
     */
    protected $jenis;

    /**
     * @var \Simdes\Repositories\Akun\ObyekRepositoryInterface
     */
    protected $obyek;

    /**
     * @var \Simdes\Repositories\Akun\RincianObyekRepositoryInterface
     */
    protected $rincianObyek;

    /**
     * @var \Simdes\Repositories\Kewenangan\KegiatanRepositoryInterface
     */
    protected $kegiatan;

    /**
     * @var \Simdes\Models\Belanja\RencanaBelanja
     */
    protected $rencanBelanja;


    /**
     * @param Belanja $belanja
     * @param RencanaBelanja $rencanaBelanja
     * @param KelompokRepositoryInterface $kelompok
     * @param JenisRepositoryInterface $jenis
     * @param ObyekRepositoryInterface $obyek
     * @param RincianObyekRepositoryInterface $rincianObyek
     * @param KegiatanRepositoryInterface $kegiatan
     */
    public function __construct(Belanja $belanja,
                                RencanaBelanja $rencanaBelanja,
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
        $this->rencanBelanja = $rencanaBelanja;
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
     * @param RencanaBelanja $rencanaBelanja
     * @param array $data
     * @return RencanaBelanja
     */
    public function update(RencanaBelanja $rencanaBelanja, array $data)
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

        $rencanaBelanja->tahun = e($data['tahun']);
        $rencanaBelanja->user_id = $data['user_id'];
        $rencanaBelanja->kegiatan_id = $kegiatan_id;
        $rencanaBelanja->kelompok_id = $kelompok_id;
        $rencanaBelanja->jenis_id = $jenis_id;
        $rencanaBelanja->obyek_id = $obyek_id;
        $rencanaBelanja->rincian_obyek_id = $rincian_obyek_id;
        $rencanaBelanja->volume_1 = e($data['volume_1']);
        $rencanaBelanja->volume_2 = e($data['volume_2']);
        $rencanaBelanja->volume_3 = e($data['volume_3']);
        $rencanaBelanja->satuan_1 = e(ucfirst(strtolower($data['satuan_1'])));
        $rencanaBelanja->satuan_2 = e(ucfirst(strtolower($data['satuan_2'])));
        $rencanaBelanja->satuan_3 = e(ucfirst(strtolower($data['satuan_3'])));
        $rencanaBelanja->belanja = $this->getNamaBelanja($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $rencanaBelanja->kode_rekening = $this->getKodeRekening($kelompok_id, $jenis_id, $obyek_id, $rincian_obyek_id);
        $rencanaBelanja->jumlah = $this->getJumlah($vol1, $vol2, $vol3, $harga_satuan);
        $rencanaBelanja->kegiatan = $this->getKegiatan($kegiatan_id);
        $rencanaBelanja->rkpdesa_id = $data['rkpdesa_id'];
        $rencanaBelanja->pagu_anggaran = $data['pagu_anggaran'];
        $rencanaBelanja->satuan_harga = $harga_satuan;
        $rencanaBelanja->save();

        return $rencanaBelanja;
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
        return new BelanjaRencanaForm();
    }

    /**
     * @return BelanjaEditForm
     */
    public function getEditForm()
    {
        return new BelanjaRencanaEditForm();
    }

}