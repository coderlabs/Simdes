<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 09:32
 */

namespace Simdes\Repositories\Eloquent\SSH;


use Simdes\Models\SSH\KelasBarang;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\SSH\KelasBarangRepositoryInterface;
use Simdes\Repositories\SSH\KelompokBarangRepositoryInterface;
use Simdes\Services\Forms\SSH\KelasBarangEditForm;
use Simdes\Services\Forms\SSH\KelasBarangForm;

/**
 * Class KelasBarangRepository
 *
 * @package Simdes\Repositories\Eloquent\ssh
 */
class KelasBarangRepository extends AbstractRepository implements KelasBarangRepositoryInterface
{

    /**
     * @var KelompokBarangRepositoryInterface
     */
    protected $kelompok;

    /**
     * @param KelasBarang $kelasBarang
     */
    public function __construct(KelasBarang $kelasBarang,KelompokBarangRepositoryInterface $kelompok)
    {
        $this->model = $kelasBarang;
        $this->kelompok = $kelompok;
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
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $kelasBarang = $this->getNew();

        $kelasBarang->kode_rekening = e($data['kode_rekening']);
        $kelasBarang->kelas = e($data['kelas']);
        $kelasBarang->save();

        return $kelasBarang;
    }

    /**
     * @param KelasBarang $kelasBarang
     * @param array $data
     *
     * @return KelasBarang
     */
    public function update(KelasBarang $kelasBarang, array $data)
    {

        $kelasBarang->kode_rekening = e($data['kode_rekening']);
        $kelasBarang->kelas = e($data['kelas']);
        $kelasBarang->save();

        return $kelasBarang;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        // get data by Id
        $kelasBarang = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($kelasBarang->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi dikelommpok, silahkan untuk menghapus data yang ada dikelompok terlebih dahulu.'
            ];
        }

        // hapus data
        $kelasBarang->delete();


        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }

    /**
     * @param $kelas_id
     * @return mixed
     */
    public function cekForDelete($kelas_id)
    {
        return $this->kelompok->findIsExists($kelas_id);
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
     * @return KelasBarangForm
     */
    public function getCreationForm()
    {
        return new KelasBarangForm();
    }

    /**
     * @return KelasBarangEditForm
     */
    public function getEditForm()
    {
        return new KelasBarangEditForm();
    }

    /**
     * @return mixed
     */
    public function getListKelasBarang()
    {
        return $this->model->get(['id', 'kelas','kode_rekening']);
    }
}