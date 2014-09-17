<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:15
 */

namespace Simdes\Repositories\Eloquent\Akun;


use Simdes\Models\Akun\Kelompok;
use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Services\Forms\Akun\KelompokEditForm;
use Simdes\Services\Forms\Akun\KelompokForm;

/**
 * Class KelompokRepository
 *
 * @package Simdes\Repositories\Eloquent\Akun
 */
class KelompokRepository extends AbstractRepository implements KelompokRepositoryInterface
{
    /**
     * @var JenisRepositoryInterface
     */
    private $jenis;

    /**
     * @param Kelompok $kelompok
     */
    public function __construct(Kelompok $kelompok, JenisRepositoryInterface $jenis)
    {
        $this->model = $kelompok;
        $this->jenis = $jenis;
    }

    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term)
    {
        return $this->model
            ->orderBy('id')
            ->FullTextSearch($term)
            ->with('akun')
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $kelompok = $this->getNew();

        $kelompok->kode_rekening = e($data['kode_rekening']);
        $kelompok->akun_id = e($data['akun_id']);
        $kelompok->kelompok = e($data['kelompok']);
        $kelompok->save();

        return $kelompok;
    }

    /**
     * @param Kelompok $kelompok
     * @param array $data
     *
     * @return Kelompok
     */
    public function update(Kelompok $kelompok, array $data)
    {
        $kelompok->kode_rekening = e($data['kode_rekening']);
        $kelompok->akun_id = e($data['akun_id']);
        $kelompok->kelompok = e($data['kelompok']);
        $kelompok->save();

        return $kelompok;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        // get data by Id
        $kelompok = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($kelompok->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi dijenis, silahkan untuk menghapus data yang ada dijenis terlebih dahulu.'
            ];
        }

        // hapus data
        $kelompok->delete();

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
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
     * @param $akun_id
     *
     * @return mixed
     */
    public function findbyIdAkun($akun_id)
    {
        return $this->model->where('akun_id', '=', $akun_id)->get(['id', 'kelompok']);
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id)
    {
        return $this->model
            ->where('id', '=', $id)
            ->with('akun')
            ->first();
    }

    /**
     * @return KelompokForm
     */
    public function getCreationForm()
    {
        return new KelompokForm();
    }

    /**
     * @return KelompokEditForm
     */
    public function getEditForm()
    {
        return new KelompokEditForm();
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->get(['id', 'kelompok', 'kode_rekening']);
    }

    /**
     * Method dipakai untuk mengecek apakah data dengan
     * akun_id bersangkutan dipakai oleh relasi
     * difungsi, untuk diperbolehkan hapus data tsb
     *
     * @param $akun_id
     * @return mixed
     */
    public function findIsExists($akun_id)
    {
        return $this->model
            ->where('akun_id', '=', $akun_id)
            ->get();
    }

    /**
     * @param $kelompok_id
     * @return mixed
     */
    public function cekForDelete($kelompok_id)
    {
        return $this->jenis->findIsExists($kelompok_id);
    }
}