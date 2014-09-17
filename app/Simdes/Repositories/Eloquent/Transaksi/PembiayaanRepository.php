<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/9/2014
 * Time: 10:00
 */

namespace Simdes\Repositories\Eloquent\Transaksi;


use Simdes\Models\Pembiayaan\Pembiayaan;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface;
use Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface;
use Simdes\Repositories\Transaksi\PembiayaanRepositoryInterface;
use Simdes\Repositories\User\UserRepositoryInterface;

/**
 * Class PembiayaanRepository
 * @package Simdes\Repositories\Eloquent\Transaksi
 */
class PembiayaanRepository extends AbstractRepository implements PembiayaanRepositoryInterface
{

    /**
     * @var
     */
    protected $pembiayaan;

    /**
     * @var \Simdes\Repositories\Pejabat\PejabatDesaRepositoryInterface
     */
    protected $pejabat;

    /**
     * @var \Simdes\Repositories\User\UserRepositoryInterface
     */
    protected $auth;

    /**
     * @var \Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface
     */
    protected $anggPembiayaan;

    /**
     * @var \Simdes\Repositories\Organisasi\OrganisasiRepositoryInterface
     */
    protected $organisasi;

    /**
     * @param Pembiayaan $pembiayaan
     * @param PejabatDesaRepositoryInterface $pejabat
     * @param UserRepositoryInterface $auth
     * @param \Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface $anggPembiayaan
     * @param OrganisasiRepositoryInterface $organisasi
     */
    public function __construct(
        Pembiayaan $pembiayaan,
        PejabatDesaRepositoryInterface $pejabat,
        UserRepositoryInterface $auth,
        \Simdes\Repositories\Pembiayaan\PembiayaanRepositoryInterface $anggPembiayaan,
        OrganisasiRepositoryInterface $organisasi
    )
    {
        $this->model = $pembiayaan;
        $this->pejabat = $pejabat;
        $this->auth = $auth;
        $this->anggPembiayaan = $anggPembiayaan;
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
        $pembiayaan = $this->getNew();

        // get string penerima
        $pejabat_desa_id = e($data['pejabat_desa_id']);
        $penerima = $this->pejabat->findById($pejabat_desa_id, $this->auth->getOrganisasiId());
        $organisasi_id = e($data['organisasi_id']);

        // uraian diambil dari anggaran pendapatan
        $pembiayaan_id = $data['pembiayaan_id'];
        $kode_rekening = $this->anggPembiayaan->getKode($pembiayaan_id);
        $kode_organisasi = $this->organisasi->getKode($organisasi_id);

        // proses nomor bukti
        // gabungan = 0001.'/'.STS-kode_rekening_pendapatan.'/'.kode_organisasi.'/'.tahun
        $nomor_bukti = e($data['no_bukti']) . '/STS-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');

        $pembiayaan->pembiayaan_id = $pembiayaan_id;
        $pembiayaan->no_bukti = e($data['no_bukti']);
        $pembiayaan->no_bku = $nomor_bukti;
        $pembiayaan->tanggal = e($data['tanggal']);
        $pembiayaan->pejabat_desa_id = $pejabat_desa_id;
        $pembiayaan->penerima = $penerima->nama;
        $pembiayaan->jumlah = e($data['jumlah']);
        $pembiayaan->user_id = e($data['user_id']);
        $pembiayaan->organisasi_id = $organisasi_id;
        $pembiayaan->uraian = e($data['pembiayaan']);
        $pembiayaan->save();

        $this->updateRealisasi($pembiayaan_id);

        return $pembiayaan;
    }

    /**
     * @param $pembiayaan_id
     * @return mixed
     */
    public function updateRealisasi($pembiayaan_id)
    {
        $data['count_jumlah'] = $this->sum($pembiayaan_id);
        return $this->anggPembiayaan->realisasiAnggaran($pembiayaan_id, $data);
    }

    /**
     * @param $belanja_id
     * @return mixed
     */
    public function sum($belanja_id)
    {
        return $this->model->where('pendapatan_id', '=', $belanja_id)->sum('jumlah');
    }

    /**
     * @param Pembiayaan $pembiayaan
     * @param array $data
     * @return Pembiayaan
     */
    public function update(Pembiayaan $pembiayaan, array $data)
    {
        // get string penerima
        $pejabat_desa_id = e($data['pejabat_desa_id']);
        $penerima = $this->pejabat->findById($pejabat_desa_id, $this->auth->getOrganisasiId());
        $organisasi_id = e($data['organisasi_id']);

        // uraian diambil dari anggaran pendapatan
        $pembiayaan_id = $data['pembiayaan_id'];
        $kode_rekening = $this->anggPembiayaan->getKode($pembiayaan_id);
        $kode_organisasi = $this->organisasi->getKode($organisasi_id);

        // proses nomor bukti
        // gabungan = 0001.'/'.STS-kode_rekening_pendapatan.'/'.kode_organisasi.'/'.tahun
        $nomor_bukti = e($data['no_bukti']) . '/STS-' . $kode_rekening . '/' . $kode_organisasi . '/' . date('Y');

        $pembiayaan->pembiayaan_id = $pembiayaan_id;
        $pembiayaan->no_bukti = e($data['no_bukti']);
        $pembiayaan->no_bku = $nomor_bukti;
        $pembiayaan->tanggal = e($data['tanggal']);
        $pembiayaan->pejabat_desa_id = $pejabat_desa_id;
        $pembiayaan->penerima = $penerima->nama;
        $pembiayaan->jumlah = e($data['jumlah']);
        $pembiayaan->user_id = e($data['user_id']);
        $pembiayaan->uraian = e($data['pembiayaan']);
        $pembiayaan->save();

        $this->updateRealisasi($pembiayaan_id);

        return $pembiayaan;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $pembiayaan = $this->findById($id);
        $pembiayaan = $pembiayaan->pembiayaan_id;
        $pembiayaan->delete();
        return $this->updateRealisasi($pembiayaan_id);
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