<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:24
 */

namespace Simdes\Repositories\Eloquent\Kewenangan;

use Simdes\Models\Kewenangan\fungsi;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\BidangRepositoryInterface;
use Simdes\Repositories\Kewenangan\fungsiRepositoryInterface;
use Simdes\Services\Forms\Kewenangan\FungsiEditForm;
use Simdes\Services\Forms\Kewenangan\FungsiForm;
use Simdes\Services\Forms\Kewenangan\KewenanganEditForm;
use Simdes\Services\Forms\Kewenangan\KewenanganForm;

/**
 * Class KewenanganRepository
 * @package Simdes\Repositories\Eloquent\Kewenangan
 */
class FungsiRepository extends AbstractRepository implements FungsiRepositoryInterface
{
    /**
     * @var BidangRepositoryInterface
     */
    private $bidang;

    /**
     * @param fungsi $fungsi
     */
    public function __construct(Fungsi $fungsi, BidangRepositoryInterface $bidang)
    {
        $this->model = $fungsi;
        $this->bidang = $bidang;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function findAll($term)
    {
        return $this->model
            ->FullTextSearch($term)
            ->with('kewenangan')
            ->paginate(10);
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $fungsi = $this->getNew();

        $fungsi->kewenangan_id = e(trim($data['kewenangan_id']));
        $fungsi->kode_rekening = e(trim($data['kode_rekening']));
        $fungsi->fungsi = e(trim($data['fungsi']));
        $fungsi->save();

        return $fungsi;
    }


    /**
     * @param fungsi $fungsi
     * @param array $data
     * @return fungsi
     */
    public function update(Fungsi $fungsi, array $data)
    {
        $fungsi->kewenangan_id = e(trim($data['kewenangan_id']));
        $fungsi->fungsi = e(trim($data['fungsi']));
        $fungsi->kode_rekening = e(trim($data['kode_rekening']));
        $fungsi->save();

        return $fungsi;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        // get data by Id
        $fungsi = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($fungsi->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi di bidang, silahkan untuk menghapus data yang ada dibidang terlebih dahulu.'
            ];
        }

        // hapus data
        $fungsi->delete();

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findById($id)
    {
        return $this->model->find($id);

    }

    /**
     * @param $fungsi_id
     * @return mixed
     */
    public function cekForDelete($fungsi_id)
    {
        return $this->bidang->findIsExists($fungsi_id);
    }

    /**
     * @return KewenanganForm
     */
    public function getCreationForm()
    {
        return new FungsiForm();
    }

    /**
     * @return KewenanganEditForm
     */
    public function getEditForm()
    {
        return new FungsiEditForm();
    }

    /**
     * @param $kewenangan_id
     * @return mixed
     */
    public function findByKewenanganId($kewenangan_id)
    {
        return $this->model
            ->Kewenangan($kewenangan_id)
            ->get(['id', 'fungsi']);
    }

    /**
     * Method dipakai untuk mengecek apakah data dengan
     * kewenangan_id bersangkutan dipakai oleh relasi
     * difungsi, untuk diperbolehkan hapus data tsb
     *
     * @param $kewenangan_id
     * @return mixed
     */
    public function findIsExists($kewenangan_id)
    {
        return $this->model
            ->where('kewenangan_id', '=', $kewenangan_id)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model
            ->remember(2)
            ->get(['id', 'fungsi', 'kode_rekening']);
    }

}