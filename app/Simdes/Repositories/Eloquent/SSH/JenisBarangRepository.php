<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 13:35
 */

namespace Simdes\Repositories\Eloquent\SSH;


use Simdes\Models\SSH\JenisBarang;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\SSH\JenisBarangRepositoryInterface;
use Simdes\Repositories\SSH\ObyekBarangRepositoryInterface;
use Simdes\Services\Forms\SSH\JenisBarangEditForm;
use Simdes\Services\Forms\SSH\JenisBarangForm;

/**
 * Class JenisBarangRepository
 *
 * @package Simdes\Repositories\Eloquent\ssh
 */
class JenisBarangRepository extends AbstractRepository implements JenisBarangRepositoryInterface
{
    /**
     * @var ObyekBarangRepositoryInterface
     */
    private $obyek;

    /**
     * @param JenisBarang $jenisBarang
     */
    public function __construct(JenisBarang $jenisBarang, ObyekBarangRepositoryInterface $obyek)
    {
        $this->model = $jenisBarang;
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
        $jenisBarang = $this->getNew();

        $jenisBarang->kelompok_id = $data['kelompok_id'];
        $jenisBarang->kode_rekening = $data['kode_rekening'];
        $jenisBarang->jenis = e($data['jenis']);
        $jenisBarang->save();

        return $jenisBarang;

    }

    /**
     * @param JenisBarang $jenisBarang
     * @param array $data
     *
     * @return JenisBarang
     */
    public function update(JenisBarang $jenisBarang, array $data)
    {
        $jenisBarang->kelompok_id = $data['kelompok_id'];
        $jenisBarang->kode_rekening = $data['kode_rekening'];
        $jenisBarang->jenis = e($data['jenis']);
        $jenisBarang->save();

        return $jenisBarang;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        // get data by Id
        $jenisBarang = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($jenisBarang->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi diobyek, silahkan untuk menghapus data yang ada diobyek terlebih dahulu.'
            ];
        }

        // hapus data
        $jenisBarang->delete();

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
     * @return JenisBarangForm
     */
    public function getCreationForm()
    {
        return new JenisBarangForm();
    }

    /**
     * @return JenisBarangEditForm
     */
    public function getEditForm()
    {
        return new JenisBarangEditForm();
    }

    /**
     * @param $kelompok_id
     * @return mixed
     */
    public function getListJenisBarang($kelompok_id)
    {
        return $this->model
            ->where('kelompok_id', '=', $kelompok_id)
            ->get(['id', 'jenis', 'kode_rekening']);
    }

    /**
     * @param $kelompok_id
     * @return mixed
     */
    public function findIsExists($kelompok_id)
    {
        return $this->model
            ->where('kelompok_id', '=', $kelompok_id)
            ->get();
    }

    /**
     * @param $jenis_id
     * @return mixed
     */
    public function cekForDelete($jenis_id)
    {
        return $this->obyek->findIsExists($jenis_id);
    }

}