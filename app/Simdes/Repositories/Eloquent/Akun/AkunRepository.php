<?php
/**
 * Created by PhpStorm.
 * User: Edi Santoso
 * Date: 5/10/2014
 * Time: 16:14
 */

namespace Simdes\Repositories\Eloquent\Akun;

use Simdes\Models\Akun\Akun;
use Simdes\Repositories\Akun\AkunRepositoryInterface;
use Simdes\Repositories\Akun\KelompokRepositoryInterface;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Services\Forms\Akun\AkunEditForm;
use Simdes\Services\Forms\Akun\AkunForm;

/**
 * Class AkunRepository
 *
 * @package Simdes\Repositories\Eloquent\Akun
 */
class AkunRepository extends AbstractRepository implements AkunRepositoryInterface
{
    /**
     * @var KelompokRepositoryInterface
     */
    private $kelompok;

    /**
     * @param Akun $akun
     */
    public function __construct(Akun $akun, KelompokRepositoryInterface $kelompok)
    {
        $this->model = $akun;
        $this->kelompok = $kelompok;
    }

    /**
     * @param $term
     *
     * @return mixed
     */
    public function findAll($term)
    {
        $akun = $this->model->orderBy('id')
            ->where('akun', 'LIKE', '%' . $term . '%')
            ->paginate(10);

        return $akun;
    }

    /**
     * Input data akun
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $akun = $this->getNew();

        $akun->kode_rekening = e($data['kode_rekening']);
        $akun->akun = e($data['akun']);

        $akun->save();

        return $akun;
    }

    /**
     * update data Akun berdasarkan $id
     *
     * @param Akun $akun
     * @param array $data
     *
     * @return Akun
     */
    public function update(Akun $akun, array $data)
    {
        $akun->kode_rekening = e($data['kode_rekening']);
        $akun->akun = e($data['akun']);

        $akun->save();

        return $akun;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        // get data by Id
        $akun = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($akun->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi di fungsi, silahkan untuk menghapus data yang ada difungsi terlebih dahulu.'
            ];
        }

        // hapus data
        $akun->delete();

        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];

    }

    /**
     * Menampilkan data Akun berdasarkan $id
     *
     * @param $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $akun_id
     * @return mixed
     */
    public function cekForDelete($akun_id)
    {
        return $this->kelompok->findIsExists($akun_id);
    }

    /**
     * Get form untuk input data Akun
     *
     * @return AkunForm
     */
    public function getCreationForm()
    {
        return new AkunForm();
    }

    /**
     * Get form untuk Update data Akun
     *
     * @param $id
     *
     * @return AkunEditForm
     */
    public function getEditForm($id)
    {
        return new AkunEditForm();
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id)
    {
        return $this->model->where('id', '=', $id)
//                ->where('organisasi_id', '=', $organisasi_id)
            ->first();
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->get(['id', 'akun', 'kode_rekening']);
    }
}