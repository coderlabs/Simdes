<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:01
 */

namespace Simdes\Repositories\Eloquent\Perdes;


use Simdes\Models\Perdes\DasarHukum;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\DasarHukumRepositoryInterface;
use Simdes\Services\Forms\Perdes\DasarHukumEditForm;
use Simdes\Services\Forms\Perdes\DasarHukumForm;

/**
 * Class DasarHukumRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class DasarHukumRepository extends AbstractRepository implements DasarHukumRepositoryInterface
{
    /**
     * @param DasarHukum $dasarHukum
     */
    public function __construct(DasarHukum $dasarHukum)
    {
        $this->model = $dasarHukum;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id,$perdes_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->where('perdes_id', '=', $perdes_id)
            ->where('pengundangan', 'LIKE', '%' . $term . '%')
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
        $dasarHukum = $this->getNew();

        $dasarHukum->pengundangan = e($data['pengundangan']);
        $dasarHukum->dasar_hukum = e($data['dasar_hukum']);
        $dasarHukum->perdes_id = e($data['perdes_id']);
        $dasarHukum->user_id = e($data['user_id']);
        $dasarHukum->organisasi_id = e($data['organisasi_id']);
        $dasarHukum->save();

        return $dasarHukum;
    }

    /**
     * @param DasarHukum $dasarHukum
     * @param array $data
     * @return DasarHukum
     */
    public function update(DasarHukum $dasarHukum, array $data)
    {
        $dasarHukum->pengundangan = e($data['pengundangan']);
        $dasarHukum->dasar_hukum = e($data['dasar_hukum']);
        $dasarHukum->user_id = e($data['user_id']);
        $dasarHukum->save();

        return $dasarHukum;
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
     * @return DasarHukumForm
     */
    public function getCreationForm()
    {
        return new DasarHukumForm();
    }

    /**
     * @return DasarHukumEditForm
     */
    public function getEditForm()
    {
        return new DasarHukumEditForm();
    }

} 