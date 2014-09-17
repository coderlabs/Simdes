<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:02
 */

namespace Simdes\Repositories\Eloquent\Perdes;

use Simdes\Models\Perdes\TataCara;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\TataCaraRepositoryInterface;
use Simdes\Services\Forms\Perdes\TataCaraEditForm;
use Simdes\Services\Forms\Perdes\TataCaraForm;


/**
 * Class TataCaraRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class TataCaraRepository extends AbstractRepository implements TataCaraRepositoryInterface
{
    /**
     * @param TataCara $tataCara
     */
    public function __construct(TataCara $tataCara)
    {
        $this->model = $tataCara;
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
        $tataCara= $this->getNew();

        $tataCara->judul = e($data['judul']);
        $tataCara->pasal = e($data['pasal']);
        $tataCara->pendahuluan = e($data['pendahuluan']);
        $tataCara->poin = e($data['poin']);
        $tataCara->perdes_id = e($data['perdes_id']);
        $tataCara->user_id = e($data['user_id']);
        $tataCara->organisasi_id = e($data['organisasi_id']);
        $tataCara->save();

        return $tataCara;
    }

    /**
     * @param TataCara $tataCara
     * @param array $data
     * @return TataCara
     */
    public function update(TataCara $tataCara, array $data)
    {
        $tataCara->judul = e($data['judul']);
        $tataCara->pasal = e($data['pasal']);
        $tataCara->pendahuluan = e($data['pendahuluan']);
        $tataCara->poin = e($data['poin']);
        $tataCara->user_id = e($data['user_id']);
        $tataCara->save();

        return $tataCara;
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
     * @return TataCaraForm
     */
    public function getCreationForm()
    {
        return new TataCaraForm();
    }

    /**
     * @return TataCaraEditForm
     */
    public function getEditForm()
    {
        return new TataCaraEditForm();
    }

} 