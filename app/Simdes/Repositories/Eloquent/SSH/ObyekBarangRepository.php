<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/23/2014
 * Time: 15:32
 */

namespace Simdes\Repositories\Eloquent\SSH;


use Simdes\Models\SSH\ObyekBarang;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\SSH\ObyekBarangRepositoryInterface;
use Simdes\Repositories\SSH\RincianObyekBarangRepositoryInterface;
use Simdes\Services\Forms\SSH\ObyekBarangEditForm;
use Simdes\Services\Forms\SSH\ObyekBarangForm;

/**
 * Class ObyekBarangRepository
 *
 * @package Simdes\Repositories\Eloquent\ssh
 */
class ObyekBarangRepository extends AbstractRepository implements ObyekBarangRepositoryInterface
{
    /**
     * @var RincianObyekBarangRepositoryInterface
     */
    private $rincian;

    /**
     * @param ObyekBarang $obyekBarang
     */
    public function __construct(ObyekBarang $obyekBarang, RincianObyekBarangRepositoryInterface $rincian)
    {
        $this->model = $obyekBarang;
        $this->rincian = $rincian;
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
            ->with('jenis')
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $obyekBarang = $this->getNew();

        $obyekBarang->kode_rekening = $data['kode_rekening'];
        $obyekBarang->jenis_id = $data['jenis_id'];
        $obyekBarang->obyek = $data['obyek'];
        $obyekBarang->save();

        return $obyekBarang;
    }

    /**
     * @param ObyekBarang $obyekBarang
     * @param array $data
     *
     * @return ObyekBarang
     */
    public function update(ObyekBarang $obyekBarang, array $data)
    {
        $obyekBarang->kode_rekening = $data['kode_rekening'];
        $obyekBarang->jenis_id = $data['jenis_id'];
        $obyekBarang->obyek = $data['obyek'];
        $obyekBarang->save();

        return $obyekBarang;
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {

        // get data by Id
        $obyekBarang = $this->findById($id);
        // cek apakah data dipakai oleh relasi di fungsi
        $result = $this->cekForDelete($obyekBarang->id);

        if (count($result) > 0) {
            return [
                'Status' => 'Warning',
                'msg'    => 'Data ini dipakai oleh relasi dirincian obyek, silahkan untuk menghapus data yang ada dirincian obyek terlebih dahulu.'
            ];
        }

        // hapus data
        $obyekBarang->delete();

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
     * @param $obyek_id
     * @return mixed
     */
    public function cekForDelete($obyek_id)
    {
        return $this->rincian->findIsExists($obyek_id);
    }

    /**
     * @return ObyekBarangForm
     */
    public function getCreationForm()
    {
        return new ObyekBarangForm();
    }

    /**
     * @return ObyekBarangEditForm
     */
    public function getEditForm()
    {
        return new ObyekBarangEditForm();
    }

    /**
     * @param $jenis_id
     * @return mixed
     */
    public function getListObyekBarang($jenis_id)
    {
        return $this->model->where('jenis_id', '=', $jenis_id)->get(['id', 'obyek', 'kode_rekening']);
    }

    /**
     * @param $jenis_id
     * @return mixed
     */
    public function findIsExists($jenis_id)
    {
        return $this->model
            ->where('jenis_id', '=', $jenis_id)
            ->get();
    }
}