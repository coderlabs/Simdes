<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:02
 */

namespace Simdes\Repositories\Eloquent\Perdes;

use Simdes\Models\Perdes\MateriPokokPoin;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\MateriPokokPoinRepositoryInterface;
use Simdes\Services\Forms\Perdes\MateriPokokPoinEditForm;
use Simdes\Services\Forms\Perdes\MateriPokokPoinForm;

/**
 * Class MateriPokokPoinRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class MateriPokokPoinRepository extends AbstractRepository implements MateriPokokPoinRepositoryInterface
{

    /**
     * @param MateriPokokPoin $poin
     */
    public function __construct(MateriPokokPoin $poin)
    {
        $this->model = $poin;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id,$materi_pokok_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->where('materi_pokok_id', '=', $materi_pokok_id)
            ->paginate(10);
    }

    /**
     * @param $perdes_id
     * @param $organisasi_id
     * @return mixed
     */
    public function findByPerdesId($perdes_id, $organisasi_id)
    {
        return $this->model
            ->Organisasi($organisasi_id)
            ->Perdes($perdes_id)
            ->with('judul')
            ->with('poin')
            ->first();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $materiPokok = $this->getNew();

        $materiPokok->materi_pokok_id = e($data['materi_pokok_id']);
        $materiPokok->poin = e($data['poin']);
        $materiPokok->user_id = e($data['user_id']);
        $materiPokok->organisasi_id = e($data['organisasi_id']);
        $materiPokok->save();

        return $materiPokok;
    }

    /**
     * @param MateriPokokPoin $poin
     * @param array $data
     * @return MateriPokokPoin
     */
    public function update(MateriPokokPoin $poin, array $data)
    {
        $poin->poin = e($data['poin']);
        $poin->user_id = e($data['user_id']);
        $poin->save();

        return $poin;
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
     * @return MateriPokokPoinForm
     */
    public function getCreationForm()
    {
        return new MateriPokokPoinForm();
    }

    /**
     * @return MateriPokokPoinEditForm
     */
    public function getEditForm()
    {
        return new MateriPokokPoinEditForm();
    }

} 