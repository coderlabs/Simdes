<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:02
 */

namespace Simdes\Repositories\Eloquent\Perdes;

use Simdes\Models\Perdes\MateriPokok;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\MateriPokokRepositoryInterface;
use Simdes\Services\Forms\Perdes\MateriPokokEditForm;
use Simdes\Services\Forms\Perdes\MateriPokokForm;

/**
 * Class MekanismeRepository
 * @package Simdes\Repositories\Eloquent\Perdes
 */
class MateriPokokRepository extends AbstractRepository implements MateriPokokRepositoryInterface
{

    /**
     * @param MateriPokok $materiPokok
     */
    public function __construct(MateriPokok $materiPokok)
    {
        $this->model = $materiPokok;
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
            ->get();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $materiPokok = $this->getNew();

        $materiPokok->perdes_id = e($data['perdes_id']);
        $materiPokok->judul = e(strtoupper($data['judul']));
        $materiPokok->pasal = e(ucfirst($data['pasal']));
        $materiPokok->bab = e(strtoupper($data['bab']));
        $materiPokok->uraian = e($data['uraian']);
        $materiPokok->user_id = e($data['user_id']);
        $materiPokok->organisasi_id = e($data['organisasi_id']);
        $materiPokok->save();

        return $materiPokok;
    }

    /**
     * @param MateriPokok $materiPokok
     * @param array $data
     * @return MateriPokok
     */
    public function update(MateriPokok $materiPokok, array $data)
    {
        $materiPokok->judul = e(strtoupper($data['judul']));
        $materiPokok->pasal = e(ucfirst($data['pasal']));
        $materiPokok->bab = e(strtoupper($data['bab']));
        $materiPokok->uraian = e($data['uraian']);
        $materiPokok->user_id = e($data['user_id']);
        $materiPokok->save();

        return $materiPokok;
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
     * @return MateriPokokForm
     */
    public function getCreationForm()
    {
        return new MateriPokokForm();
    }

    /**
     * @return MateriPokokEditForm
     */
    public function getEditForm()
    {
        return new MateriPokokEditForm();
    }

} 