<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 13:21
 */

namespace Simdes\Repositories\Eloquent\SSH;


use Simdes\Models\SSH\KelompokBarang;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\SSH\JenisBarangRepositoryInterface;
use Simdes\Repositories\SSH\KelompokBarangRepositoryInterface;
use Simdes\Services\Forms\SSH\KelompokBarangEditForm;
use Simdes\Services\Forms\SSH\KelompokBarangForm;

/**
 * Class KelompokBarangRepository
 *
 * @package Simdes\Repositories\Eloquent\ssh
 */
class KelompokBarangRepository extends AbstractRepository implements KelompokBarangRepositoryInterface
{
    /**
     * @var JenisBarangRepositoryInterface
     */
    private $jenis;

    /**
     * @param KelompokBarang $kelompokBarang
     */
    public function __construct(KelompokBarang $kelompokBarang, JenisBarangRepositoryInterface $jenis)
    {
        $this->model = $kelompokBarang;
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
            ->FullTextSearch($term)
            ->with('kelas')
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $kelompokBarang = $this->getNew();

        $kelompokBarang->kode_rekening = e($data['kode_rekening']);
        $kelompokBarang->kelas_id = e($data['kelas_id']);
        $kelompokBarang->kelompok = e($data['kelompok']);
        $kelompokBarang->save();

        return $kelompokBarang;
    }

    /**
     * @param KelompokBarang $kelompokBarang
     * @param array $data
     *
     * @return KelompokBarang
     */
    public function update(KelompokBarang $kelompokBarang, array $data)
    {
        $kelompokBarang->kode_rekening = e($data['kode_rekening']);
        $kelompokBarang->kelas_id = e($data['kelas_id']);
        $kelompokBarang->kelompok = e($data['kelompok']);
        $kelompokBarang->save();

        return $kelompokBarang;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        // get data by Id
        $kelompokBarang = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($kelompokBarang->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi dijenis, silahkan untuk menghapus data yang ada dijenis terlebih dahulu.'
            ];
        }

        // hapus data
        $kelompokBarang->delete();

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
     * @param $kelompok_id
     * @return mixed
     */
    public function cekForDelete($kelompok_id)
    {
        return $this->jenis->findIsExists($kelompok_id);
    }

    /**
     * @return KelompokBarangForm
     */
    public function getCreationForm()
    {
        return new KelompokBarangForm();
    }

    /**
     * @return KelompokBarangEditForm
     */
    public function geteditForm()
    {
        return new KelompokBarangEditForm();
    }

    /**
     * @param $kelas_id
     * @return mixed
     */
    public function getListKelompokBarang($kelas_id)
    {
        return $this->model->where('kelas_id', '=', $kelas_id)->get(['id', 'kelompok', 'kode_rekening']);
    }

    /**
     * @param $kelas_id
     * @return mixed
     */
    public function findIsExists($kelas_id)
    {
        return $this->model
            ->where('kelas_id', '=', $kelas_id)
            ->get();
    }

}