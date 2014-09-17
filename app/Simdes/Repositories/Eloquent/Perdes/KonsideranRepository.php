<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 20:59
 */

namespace Simdes\Repositories\Eloquent\Perdes;


use Simdes\Models\Perdes\Konsideran;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\KonsideranRepositoryInterface;
use Simdes\Services\Forms\Perdes\KonsideranEditForm;
use Simdes\Services\Forms\Perdes\KonsideranForm;

/**
 * Class KonsideranRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class KonsideranRepository extends AbstractRepository implements KonsideranRepositoryInterface
{

    /**
     * @param Konsideran $konsideran
     */
    public function __construct(Konsideran $konsideran)
    {
        $this->model = $konsideran;
    }

    /**
     * @param $term
     * @param $organisasi_id
     * @return mixed
     */
    public function findAll($term, $organisasi_id, $perdes_id)
    {
        return $this->model
            ->where('organisasi_id', '=', $organisasi_id)
            ->where('perdes_id', '=', $perdes_id)
            ->where('konsideran', 'LIKE', '%' . $term . '%')
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
        $konsideran = $this->getNew();

        $konsideran->konsideran = e($data['konsideran']);
        $konsideran->perdes_id = e($data['perdes_id']);
        $konsideran->user_id = e($data['user_id']);
        $konsideran->organisasi_id = e($data['organisasi_id']);
        $konsideran->save();

        return $konsideran;
    }

    /**
     * @param Konsideran $konsideran
     * @param array $data
     * @return Konsideran
     */
    public function update(Konsideran $konsideran, array $data)
    {

        $konsideran->konsideran = e($data['konsideran']);
        $konsideran->user_id = e($data['user_id']);
        $konsideran->save();

        return $konsideran;
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
     * @return KonsideranForm
     */
    public function getCreationForm()
    {
        return new KonsideranForm();
    }

    /**
     * @return KonsideranEditForm
     */
    public function getEditForm()
    {
        return new KonsideranEditForm();
    }

} 