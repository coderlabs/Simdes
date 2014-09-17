<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:02
 */

namespace Simdes\Repositories\Eloquent\Perdes;


use Simdes\Models\Perdes\BatangTubuh;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\BatangTubuhRepositoryInterface;
use Simdes\Services\Forms\Perdes\BatangTubuhEditForm;
use Simdes\Services\Forms\Perdes\BatangTubuhForm;

/**
 * Class BatangTubuhRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class BatangTubuhRepository extends AbstractRepository implements BatangTubuhRepositoryInterface
{
    /**
     * @param BatangTubuh $batangTubuh
     */
    public function __construct(BatangTubuh $batangTubuh)
    {
        $this->model = $batangTubuh;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)
            ->where('istilah', 'LIKE', '%' . $term . '%')
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
        $batangTubuh = $this->getNew();

        $batangTubuh->istilah = e($data['istilah']);
        $batangTubuh->perdes_id = e($data['perdes_id']);
        $batangTubuh->user_id = e($data['user_id']);
        $batangTubuh->organisasi_id = e($data['organisasi_id']);
        $batangTubuh->save();

        return $batangTubuh;
    }

    /**
     * @param BatangTubuh $batangTubuh
     * @param array $data
     * @return BatangTubuh
     */
    public function update(BatangTubuh $batangTubuh, array $data)
    {

        $batangTubuh->istilah = e($data['istilah']);
        $batangTubuh->perdes_id = e($data['perdes_id']);
        $batangTubuh->user_id = e($data['user_id']);
        $batangTubuh->save();

        return $batangTubuh;
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
     * @return BatangTubuhForm
     */
    public function getCreationForm()
    {
        return new BatangTubuhForm();
    }


    /**
     * @return BatangTubuhEditForm
     */
    public function getEditForm()
    {
        return new BatangTubuhEditForm();
    }

} 