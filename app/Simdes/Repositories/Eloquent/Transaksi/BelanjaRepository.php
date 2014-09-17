<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/9/2014
 * Time: 09:16
 */

namespace Simdes\Repositories\Eloquent\Transaksi;


use Simdes\Models\Transaksi\Belanja;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\Transaksi\BelanjaRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;
use Simdes\Services\Forms\Transaksi\BelanjaEditForm;
use Simdes\Services\Forms\Transaksi\BelanjaForm;

/**
 * Class BelanjaRepository
 * @package Simdes\Repositories\Eloquent\Transaksi
 */
class BelanjaRepository extends AbstractRepository implements BelanjaRepositoryInterface
{

    /**
     * @var
     */
    protected $belanja;

    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;

    /**
     * @var \Simdes\Repositories\User\UserRepositoryInterface
     */
    protected $auth;

    /**
     * @var \Simdes\Repositories\Belanja\BelanjaRepositoryInterface
     */
    protected $anggBelanja;

    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;


    /**
     * @param Belanja $belanja
     * @param PejabatDesaRepositoryInterface $pejabat
     * @param UserRepositoryInterface $auth
     * @param \Simdes\Repositories\Belanja\BelanjaRepositoryInterface $anggBelanja
     * @param OrganisasiRepositoryInterface $organisasi
     */
    public function __construct(
        Belanja $belanja,
        PejabatDesaRepositoryInterface $pejabat,
        UserRepositoryInterface $auth,
        \Simdes\Repositories\Belanja\BelanjaRepositoryInterface $anggBelanja,
        OrganisasiRepositoryInterface $organisasi
    )
    {
        $this->model = $belanja;
        $this->pejabat = $pejabat;
        $this->auth = $auth;
        $this->anggBelanja = $anggBelanja;
        $this->organisasi = $organisasi;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('uraian', 'LIKE', '%' . $term . '%')
            ->paginate(10);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $belanja = $this->getNew();

        // get string penerima
        $pejabat_desa_id = e($data['pejabat_desa_id']);
        $penerima = $this->pejabat->findById($pejabat_desa_id, $this->auth->getOrganisasiId());
        $organisasi_id = e($data['organisasi_id']);

        // uraian diambil dari anggaran pendapatan
        $belanja_id = $data['belanja_id'];
        $kode_rekening = $this->anggBelanja->getKode($belanja_id);
        $kode_organisasi = $this->organisasi->getKode($organisasi_id);

        // proses nomor bukti
        // gabungan = 0001.'/'.STS-kode_rekening_pendapatan.'/'.kode_organisasi.'/'.tahun
        $nomor_bukti = e($data['no_bukti']) . '/TRSK-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');
        $no_bku_trsk = e($data['no_bukti']) . '/BKT.TRSK-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');
        $item = e($data['item']);
        $harga = e($data['harga']);

        $belanja->belanja_id = $belanja_id;
        $belanja->no_bukti = e($data['no_bukti']);
        $belanja->tanggal = e($data['tanggal']);
        $belanja->pejabat_desa_id = $pejabat_desa_id;
        $belanja->penerima = $penerima->nama;
        $belanja->no_bku = $nomor_bukti;
        $belanja->no_bku_trsk = $no_bku_trsk;
        $belanja->jumlah = $item * $harga;
        $belanja->uraian = e($data['barang']);
        $belanja->user_id = e($data['user_id']);
        $belanja->organisasi_id = $organisasi_id;
        $belanja->ssh_id = e($data['ssh_id']);
        $belanja->kegiatan = e($data['belanja']);
        $belanja->kode_barang = e($data['kode_barang']);
        $belanja->item = $item;
        $belanja->harga = $harga;
        $belanja->save();

        $this->updateRealisasi($belanja_id);

        return $belanja;
    }

    /**
     * @param $belanja_id
     * @return mixed
     */
    public function updateRealisasi($belanja_id)
    {
        $data['count_jumlah'] = $this->sum($belanja_id);
        return $this->anggBelanja->realisasiAnggaran($belanja_id, $data);
    }

    /**
     * @param $belanja_id
     * @return mixed
     */
    public function sum($belanja_id)
    {
        return $this->model->where('belanja_id', '=', $belanja_id)->sum('jumlah');
    }


    /**
     * @param Belanja $belanja
     * @param array $data
     * @return Belanja
     */
    public function update(Belanja $belanja, array $data)
    {
        // get string penerima
        $pejabat_desa_id = e($data['pejabat_desa_id']);
        $penerima = $this->pejabat->findById($pejabat_desa_id, $this->auth->getOrganisasiId());
        $organisasi_id = e($data['organisasi_id']);

        // uraian diambil dari anggaran pendapatan
        $belanja_id = $data['belanja_id'];
        $kode_rekening = $this->anggBelanja->getKode($belanja_id);
        $kode_organisasi = $this->organisasi->getKode($organisasi_id);

        // proses nomor bukti
        // gabungan = 0001.'/'.STS-kode_rekening_pendapatan.'/'.kode_organisasi.'/'.tahun
        $nomor_bukti = e($data['no_bukti']) . '/TRSK-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');
        $no_bku_trsk = e($data['no_bukti']) . '/BKT.TRSK-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');
        $item = e($data['item']);
        $harga = e($data['harga']);

        $belanja->belanja_id = $belanja_id;
        $belanja->no_bukti = e($data['no_bukti']);
        $belanja->tanggal = e($data['tanggal']);
        $belanja->pejabat_desa_id = $pejabat_desa_id;
        $belanja->penerima = $penerima->nama;
        $belanja->no_bku = $nomor_bukti;
        $belanja->no_bku_trsk = $no_bku_trsk;
        $belanja->jumlah = $item * $harga;
        $belanja->uraian = e($data['barang']);
        $belanja->user_id = e($data['user_id']);
        $belanja->ssh_id = e($data['ssh_id']);
        $belanja->kegiatan = e($data['belanja']);
        $belanja->kode_barang = e($data['kode_barang']);
        $belanja->item = $item;
        $belanja->harga = $harga;
        $belanja->save();

        $this->updateRealisasi($belanja_id);

        return $belanja;
    }

    public function findByDate($term, $dateStart,$dateEnd,$organisasi_id)
    {
        return $this->model
            ->Organisasi($organisasi_id)
            ->FullTextSearch($term)
            ->whereBetween('tanggal',[$dateStart,$dateEnd])
            ->orderBy('tanggal','desc')
            ->paginate(10);
    }

    public function findForBku($dateStart,$dateEnd,$organisasi_id){
        return $this->model
            ->Organisasi($organisasi_id)
            ->whereBetween('tanggal',[$dateStart,$dateEnd])
            ->get();
    }

    public function jumlahBulanIni($dateStart,$dateEnd,$organisasi_id){
        return $this->model
            ->Organisasi($organisasi_id)
            ->whereBetween('tanggal',[$dateStart,$dateEnd])
            ->sum('jumlah');
    }

    public function jumlahSampaiBulanIni($organisasi_id){
        return $this->model
            ->Organisasi($organisasi_id)
            ->sum('jumlah');
    }

    public function posting(Belanja $belanja)
    {
        // posting transaksi pendapatan untuk bisa dicetak di bukti transaksi
        $belanja->is_posting = 1;
        $belanja->save();

        return $belanja;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $belanja = $this->findById($id);
        $belanja_id = $belanja->belanja_id;
        $belanja->delete();
        return $this->updateRealisasi($belanja_id);
    }

    /**
     * @param $id
     * @return mixed
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

} 