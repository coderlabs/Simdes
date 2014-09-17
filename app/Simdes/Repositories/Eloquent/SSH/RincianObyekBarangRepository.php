<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 17:18
 */

namespace Simdes\Repositories\Eloquent\SSH;


use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\SSH\RincianObyekBarangRepositoryInterface;
use Simdes\Models\SSH\RincianObyekBarang;
use Simdes\Services\Forms\SSH\RincianObyekBarangEditForm;
use Simdes\Services\Forms\SSH\RincianObyekBarangForm;

/**
 * Class RincianObyekBarangRepository
 *
 * @package Simdes\Repositories\Eloquent\ssh
 */
class RincianObyekBarangRepository extends AbstractRepository implements RincianObyekBarangRepositoryInterface
{

    /**
     * @param RincianObyekBarang $rincianObyekBarang
     */
    public function __construct(RincianObyekBarang $rincianObyekBarang)
    {
        $this->model = $rincianObyekBarang;
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
            ->with('obyek')
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $rincianObyekBarang = $this->getNew();

        $rincianObyekBarang->kode_rekening = e($data['kode_rekening']);
        $rincianObyekBarang->obyek_id = e($data['obyek_id']);
        $rincianObyekBarang->rincian_obyek = e($data['rincian_obyek']);
        $rincianObyekBarang->spesifikasi = e($data['spesifikasi']);
        $rincianObyekBarang->harga = e($data['harga']);
        $rincianObyekBarang->satuan = e($data['satuan']);
        $rincianObyekBarang->save();

        return $rincianObyekBarang;
    }

    /**
     * @param RincianObyekBarang $rincianObyekBarang
     * @param array $data
     *
     * @return RincianObyekBarang
     */
    public function update(RincianObyekBarang $rincianObyekBarang, array $data)
    {
        $rincianObyekBarang->kode_rekening = e($data['kode_rekening']);
        $rincianObyekBarang->obyek_id = e($data['obyek_id']);
        $rincianObyekBarang->rincian_obyek = e($data['rincian_obyek']);
        $rincianObyekBarang->spesifikasi = e($data['spesifikasi']);
        $rincianObyekBarang->harga = e($data['harga']);
        $rincianObyekBarang->satuan = e($data['satuan']);
        $rincianObyekBarang->save();

        return $rincianObyekBarang;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $rincianObyekbarang = $this->findById($id);
        $rincianObyekbarang->delete();
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
     * @return RincianObyekBarangForm
     */
    public function getCreationForm()
    {
        return new RincianObyekBarangForm();
    }

    /**
     * @return RincianObyekBarangEditForm
     */
    public function getEditForm()
    {
        return new RincianObyekBarangEditForm();
    }

    /**
     * @param $term
     * @return mixed
     */
    public function autocomplete($term)
    {
        return $this->model
            ->FullTextSearch($term)
            ->get(['id', 'rincian_obyek', 'spesifikasi', 'satuan', 'harga', 'kode_barang']);
    }

    public function findIsExists($obyek_id){
        return $this->model
            ->where('obyek_id', '=', $obyek_id)
            ->get();
    }
}