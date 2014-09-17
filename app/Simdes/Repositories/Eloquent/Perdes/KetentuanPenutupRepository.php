<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:02
 */

namespace Simdes\Repositories\Eloquent\Perdes;

use Simdes\Models\Perdes\KetentuanPenutup;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\KetentuanPenutupRepositoryInterface;
use Simdes\Services\Forms\Perdes\KetentuanPenutupEditForm;
use Simdes\Services\Forms\Perdes\KetentuanPenutupForm;


/**
 * Class KetentuanPenutupRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class KetentuanPenutupRepository extends AbstractRepository implements KetentuanPenutupRepositoryInterface
{
    /**
     * @param KetentuanPenutup $ketentuanPenutup
     */
    public function __construct(KetentuanPenutup $ketentuanPenutup)
    {
        $this->model = $ketentuanPenutup;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('poin', 'LIKE', '%' . $term . '%')
            ->with('judul')
            ->paginate(10);
    }

    /**
     * @param $perdes_id
     * @param $organisasi_id
     * @return mixed
     */
    public function findByPerdesId($perdes_id, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('perdes_id', '=', $perdes_id)
            ->first();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $ketentuanPenutup = $this->getNew();

        $ketentuanPenutup->judul = e($data['judul']);
        $ketentuanPenutup->pasal = e($data['pasal']);
        $ketentuanPenutup->pendahuluan = e($data['pendahuluan']);
        $ketentuanPenutup->poin = e($data['poin']);
        $ketentuanPenutup->perdes_id = e($data['perdes_id']);
        $ketentuanPenutup->user_id = e($data['user_id']);
        $ketentuanPenutup->organisasi_id = e($data['organisasi_id']);
        $ketentuanPenutup->save();

        return $ketentuanPenutup;
    }

    /**
     * @param KetentuanPenutup $ketentuanPenutup
     * @param array $data
     * @return KetentuanPenutup
     */
    public function update(KetentuanPenutup $ketentuanPenutup, array $data)
    {

        $ketentuanPenutup->judul = e($data['judul']);
        $ketentuanPenutup->pasal = e($data['pasal']);
        $ketentuanPenutup->pendahuluan = e($data['pendahuluan']);
        $ketentuanPenutup->poin = e($data['poin']);
        $ketentuanPenutup->user_id = e($data['user_id']);
        $ketentuanPenutup->save();

        return $ketentuanPenutup;
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return void
     */
    public function delete($id, $organisasi_id)
    {
        $data = $this->findById($id, $organisasi_id);
        $data->delete();
    }

    /**
     * @param $id
     * @param $organisasi_id
     * @return mixed
     */
    public function findById($id, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * @return KetentuanPenutupForm
     */
    public function getCreationForm()
    {
        return new KetentuanPenutupForm();
    }

    /**
     * @return KetentuanPenutupEditForm
     */
    public function getEditForm()
    {
        return new KetentuanPenutupEditForm();
    }

} 