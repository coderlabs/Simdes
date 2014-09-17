<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 18:24
 */

namespace Simdes\Repositories\Eloquent\Kewenangan;

use Simdes\Models\Kewenangan\Kewenangan;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Kewenangan\FungsiRepositoryInterface;
use Simdes\Repositories\Kewenangan\KewenanganRepositoryInterface;
use Simdes\Services\Forms\Kewenangan\KewenanganEditForm;
use Simdes\Services\Forms\Kewenangan\KewenanganForm;

/**
 * Class KewenanganRepository
 * @package Simdes\Repositories\Eloquent\Kewenangan
 */
class KewenanganRepository extends AbstractRepository implements KewenanganRepositoryInterface
{

    private $fungsi;

    /**
     * @param Kewenangan $kewenangan
     */
    public function __construct(Kewenangan $kewenangan, FungsiRepositoryInterface $fungsi)
    {
        $this->model = $kewenangan;
        $this->fungsi = $fungsi;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function findAll($term)
    {
        $kewenangan = $this->model->orderBy('id')
            ->FullTextSearch($term)
            ->paginate(10);

        return $kewenangan;
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $kewenangan = $this->getNew();

        $kewenangan->kode_rekening = e(trim($data['kode_rekening']));
        $kewenangan->kewenangan = e(trim($data['kewenangan']));
        $kewenangan->save();

        return $kewenangan;
    }

    /**
     * @param Kewenangan $kewenangan
     * @param array $data
     * @return Kewenangan
     */
    public function update(Kewenangan $kewenangan, array $data)
    {
        $kewenangan->kode_rekening = e(trim($data['kode_rekening']));
        $kewenangan->kewenangan = e(trim($data['kewenangan']));
        $kewenangan->save();

        return $kewenangan;
    }

    public function delete($id)
    {
        // get data by Id
        $kewenangan = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($kewenangan->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi di fungsi, silahkan untuk menghapus data yang ada difungsi terlebih dahulu.'
            ];
        }

        // hapus data
        $kewenangan->delete();


        return [
            'Status' => 'Sukses',
            'msg'    => 'Sukses : Data berhasil dihapus.'
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function cekForDelete($kewenangan_id)
    {
        return $this->fungsi->findIsExists($kewenangan_id);
    }

    /**
     * @return KewenanganForm
     */
    public function getCreationForm()
    {
        return new KewenanganForm();
    }

    /**
     * @return KewenanganEditForm
     */
    public function getEditForm()
    {
        return new KewenanganEditForm();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getList()
    {
        return $this->model->all(['id', 'kewenangan', 'kode_rekening']);
    }

   

}