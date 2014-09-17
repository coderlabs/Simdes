<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:25
 */

namespace Simdes\Repositories\Eloquent\Akun;

use Simdes\Models\Akun\Jenis;
use Simdes\Repositories\Akun\JenisRepositoryInterface;
use Simdes\Repositories\Akun\ObyekRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Services\Forms\Akun\JenisEditForm;
use Simdes\Services\Forms\Akun\JenisForm;

/**
 * Class JenisRepository
 *
 * @package Simdes\Repositories\Eloquent\Akun
 */
class JenisRepository extends AbstractRepository implements JenisRepositoryInterface
{
    /**
     * @var ObyekRepositoryInterface
     */
    private $obyek;

    /**
     * @param Jenis $jenis
     */
    public function __construct(Jenis $jenis, ObyekRepositoryInterface $obyek)
    {
        $this->model = $jenis;
        $this->obyek = $obyek;
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
            ->with('kelompok')
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $jenis = $this->getNew();

        $jenis->kode_rekening = e($data['kode_rekening']);
        $jenis->referensi = e($data['referensi']);
        $jenis->kelompok_id = e($data['kelompok_id']);
        $jenis->jenis = e($data['jenis']);
        $jenis->save();

        return $jenis;
    }

    /**
     * @param Jenis $jenis
     * @param array $data
     *
     * @return Jenis
     */
    public function update(Jenis $jenis, array $data)
    {
        $jenis->kode_rekening = e($data['kode_rekening']);
        $jenis->kelompok_id = e($data['kelompok_id']);
        $jenis->referensi = e($data['referensi']);
        $jenis->jenis = e($data['jenis']);
        $jenis->save();

        return $jenis;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        // get data by Id
        $jenis = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($jenis->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi diobyek, silahkan untuk menghapus data yang ada diobyek terlebih dahulu.'
            ];
        }

        // hapus data
        $jenis->delete();

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
     * @param $jenis_id
     * @return mixed
     */
    public function cekForDelete($jenis_id)
    {
        return $this->obyek->findIsExists($jenis_id);
    }

    /**
     * @param $kelompok_id
     *
     * @return mixed
     */
    public function findByIdKelompok($kelompok_id)
    {
        return $this->model->where('kelompok_id', '=', $kelompok_id)->get(['id', 'jenis']);
    }

    /**
     * @return JenisForm
     */
    public function getCreationForm()
    {
        return new JenisForm();
    }

    /**
     * @return JenisEditForm
     */
    public function getEditForm()
    {
        return new JenisEditForm();
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
     * @return mixed
     */
    public function getList()
    {
        return $this->model->get(['id', 'jenis', 'kode_rekening']);
    }

    /**
     * Method dipakai untuk mengecek apakah data dengan
     * akun_id bersangkutan dipakai oleh relasi
     * difungsi, untuk diperbolehkan hapus data tsb
     *
     * @param $kelompok_id
     * @return mixed
     */
    public function findIsExists($kelompok_id)
    {
        return $this->model
            ->where('kelompok_id', '=', $kelompok_id)
            ->get();
    }
}