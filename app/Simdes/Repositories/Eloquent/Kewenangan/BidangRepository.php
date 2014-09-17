<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:24
 */

namespace Simdes\Repositories\Eloquent\Kewenangan;

use Simdes\Models\Kewenangan\Bidang;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\BidangRepositoryInterface;
use Simdes\Repositories\Kewenangan\ProgramRepositoryInterface;
use Simdes\Services\Forms\Kewenangan\BidangEditForm;
use Simdes\Services\Forms\Kewenangan\BidangForm;
use Simdes\Services\Forms\Kewenangan\KewenanganEditForm;
use Simdes\Services\Forms\Kewenangan\KewenanganForm;

/**
 * Class KewenanganRepository
 * @package Simdes\Repositories\Eloquent\Kewenangan
 */
class BidangRepository extends AbstractRepository implements BidangRepositoryInterface
{
    private $program;

    /**
     * @param Bidang $bidang
     */
    public function __construct(Bidang $bidang, ProgramRepositoryInterface $program)
    {
        $this->model = $bidang;
        $this->program = $program;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function findAll($term)
    {
        return $this->model
            ->FullTextSearch($term)
            ->with('fungsi')
            ->paginate(10);
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $bidang = $this->getNew();

        $bidang->fungsi_id = e(trim($data['fungsi_id']));
        $bidang->kode_rekening = e(trim($data['kode_rekening']));
        $bidang->bidang = e(trim($data['bidang']));
        $bidang->regulasi = e(trim($data['regulasi']));
        $bidang->tanggal = e(trim($data['tanggal']));
        $bidang->pengundangan = e(trim($data['pengundangan']));
        $bidang->save();

        return $bidang;
    }

    /**
     * @param Bidang $bidang
     * @param array $data
     * @return Bidang
     */
    public function update(Bidang $bidang, array $data)
    {
        $bidang->fungsi_id = e(trim($data['fungsi_id']));
        $bidang->bidang = e(trim($data['bidang']));
        $bidang->regulasi = e(trim($data['regulasi']));
        $bidang->tanggal = e(trim($data['tanggal']));
        $bidang->pengundangan = e(trim($data['pengundangan']));
        $bidang->save();

        return $bidang;
    }

    public function delete($id)
    {
        // get data by Id
        $bidang = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($bidang->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi diprogram, silahkan untuk menghapus data yang ada diprogram terlebih dahulu.'
            ];
        }

        // hapus data
        $bidang->delete();

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

    public function cekForDelete($bidang_id)
    {
        return $this->program->findIsExists($bidang_id);
    }

    /**
     * @return KewenanganForm
     */
    public function getCreationForm()
    {
        return new BidangForm();
    }

    /**
     * @return KewenanganEditForm
     */
    public function getEditForm()
    {
        return new BidangEditForm();
    }

    /**
     * @param $fungsi_id
     * @return mixed
     */
    public function findByKewenanganId($fungsi_id)
    {
        return $this->model
            ->Kewenangan($fungsi_id)
            ->get(['id', 'bidang']);
    }

    /**
     * @param $fungsi_id
     * @return mixed
     */
    public function getList($fungsi_id)
    {
        return $this->model->where('fungsi_id', '=', $fungsi_id)->get(['id', 'bidang', 'kode_rekening']);
    }

    /**
     * Method dipakai untuk mengecek apakah data dengan
     * $fungsi_id yg bersangkutan dipakai oleh relasi
     * dibidang, untuk diperbolehkan hapus data tsb
     *
     * @param $fungsi_id
     * @return mixed
     */
    public function findIsExists($fungsi_id)
    {
        return $this->model
            ->where('fungsi_id', '=', $fungsi_id)
            ->get();
    }

}