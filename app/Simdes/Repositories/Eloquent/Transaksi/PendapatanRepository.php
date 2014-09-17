<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/7/2014
 * Time: 06:21
 */

namespace Simdes\Repositories\Eloquent\Transaksi;


use Simdes\Models\Transaksi\Pendapatan;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\Transaksi\PendapatanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;
use Simdes\Services\Forms\Transaksi\PendapatanEditForm;
use Simdes\Services\Forms\Transaksi\PendapatanForm;

/**
 * Class PendapatanRepository
 * @package Simdes\Repositories\Eloquent\Transaksi
 */
class PendapatanRepository extends AbstractRepository implements PendapatanRepositoryInterface
{
    /**
     * @var
     */
    protected $pendapatan;

    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;

    /**
     * @var \Simdes\Repositories\User\UserRepositoryInterface
     */
    protected $auth;

    /**
     * @var \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface
     */
    protected $anggPendapatan;

    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;


    /**
     * @param Pendapatan $pendapatan
     * @param PejabatDesaRepositoryInterface $pejabat
     * @param UserRepositoryInterface $auth
     * @param \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface $anggPendapatan
     * @param OrganisasiRepositoryInterface $organisasi
     */
    public function __construct(
        Pendapatan $pendapatan,
        PejabatDesaRepositoryInterface $pejabat,
        UserRepositoryInterface $auth,
        \Simdes\Repositories\Pendapatan\PendapatanRepositoryInterface $anggPendapatan,
        OrganisasiRepositoryInterface $organisasi
    )
    {
        $this->model = $pendapatan;
        $this->pejabat = $pejabat;
        $this->auth = $auth;
        $this->anggPendapatan = $anggPendapatan;
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
            ->orderBy('tanggal','desc')
            ->paginate(10);
    }

    /**
     * Pencarian data berdasarkan range tanggal
     *
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
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

    public function jumlahSampaiBulanLalu($dateStart,$dateEnd,$organisasi_id){
        return $this->model
            ->Organisasi($organisasi_id)
            ->whereBetween('tanggal',[$dateStart,$dateEnd])
            ->sum('jumlah');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $pendapatan = $this->getNew();

        // get string penerima
        $pejabat_desa_id = e($data['pejabat_desa_id']);
        $penerima = $this->pejabat->findById($pejabat_desa_id, $this->auth->getOrganisasiId());
        $organisasi_id = e($data['organisasi_id']);

        // uraian diambil dari anggaran pendapatan
        $pendapatan_id = $data['pendapatan_id'];
        $kode_rekening = $this->anggPendapatan->getKode($pendapatan_id);
        $kode_organisasi = $this->organisasi->getKode($organisasi_id);

        // proses nomor bukti
        // gabungan = 0001.'/'.STS-kode_rekening_pendapatan.'/'.kode_organisasi.'/'.tahun
        $nomor_bukti = e($data['no_bukti']) . '/STS-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');
        $no_bku_sts = e($data['no_bukti']) . '/BKT.STS-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');

        $pendapatan->pendapatan_id = $pendapatan_id;
        $pendapatan->no_bukti = e($data['no_bukti']);
        $pendapatan->no_bku = $nomor_bukti;
        $pendapatan->no_bku_sts = $no_bku_sts;
        $pendapatan->tanggal = e($data['tanggal']);
        $pendapatan->pejabat_desa_id = $pejabat_desa_id;
        $pendapatan->penerima = $penerima->nama;
        $pendapatan->jumlah = e($data['jumlah']);
        $pendapatan->user_id = e($data['user_id']);
        $pendapatan->organisasi_id = $organisasi_id;
        $pendapatan->uraian = e($data['pendapatan']);
        $pendapatan->save();

        $this->updateRealisasi($pendapatan_id);

        return $pendapatan;
    }

    /**
     * @param $pendapatan_id
     * @return mixed
     */
    public function updateRealisasi($pendapatan_id)
    {
        $data['count_jumlah'] = $this->countTrPendapatan($pendapatan_id);
        return $this->anggPendapatan->realisasiAnggaran($pendapatan_id, $data);
    }

    /**
     * @param $pendapatan_id
     * @return mixed
     */
    public function countTrPendapatan($pendapatan_id)
    {
        return $this->model->where('pendapatan_id', '=', $pendapatan_id)->sum('jumlah');
    }

    /**
     * @param Pendapatan $pendapatan
     * @param array $data
     * @return mixed
     */
    public function update(Pendapatan $pendapatan, array $data)
    {
        // get string penerima
        $pejabat_desa_id = e($data['pejabat_desa_id']);
        $penerima = $this->pejabat->findById($pejabat_desa_id, $this->auth->getOrganisasiId());
        $organisasi_id = e($data['organisasi_id']);

        // uraian diambil dari anggaran pendapatan
        $pendapatan_id = $data['pendapatan_id'];
        $kode_rekening = $this->anggPendapatan->getKode($pendapatan_id);
        $kode_organisasi = $this->organisasi->getKode($organisasi_id);

        // proses nomor bukti
        // gabungan = 0001.'/'.STS-kode_rekening_pendapatan.'/'.kode_organisasi.'/'.tahun
        $nomor_bukti = e($data['no_bukti']) . '/STS-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');
        $no_bku_sts = e($data['no_bukti']) . '/BKT.STS-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');

        $pendapatan->pendapatan_id = $pendapatan_id;
        $pendapatan->no_bukti = e($data['no_bukti']);
        $pendapatan->no_bku = $nomor_bukti;
        $pendapatan->no_bku_sts = $no_bku_sts;
        $pendapatan->tanggal = e($data['tanggal']);
        $pendapatan->pejabat_desa_id = $pejabat_desa_id;
        $pendapatan->penerima = $penerima->nama;
        $pendapatan->jumlah = e($data['jumlah']);
        $pendapatan->user_id = e($data['user_id']);
        $pendapatan->uraian = e($data['pendapatan']);
        $pendapatan->save();

        $this->updateRealisasi($pendapatan_id);

        return $pendapatan;
    }
    public function posting(Pendapatan $pendapatan)
    {
        // posting transaksi pendapatan untuk bisa dicetak di bukti transaksi
        $pendapatan->is_posting = 1;
        $pendapatan->save();

        return $pendapatan;
    }
    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $pendapatan = $this->findById($id);
        $pendapatan_id = $pendapatan->pendapatan_id;
        $pendapatan->delete();
        return $this->updateRealisasi($pendapatan_id);
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
     * @return PendapatanEditForm
     */
    public function getCreationForm()
    {
        return new PendapatanForm();
    }

    /**
     * @return PendapatanEditForm
     */
    public function getEditForm()
    {
        return new PendapatanEditForm();
    }
}