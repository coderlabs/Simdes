<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/15/2014
 * Time: 21:02
 */

namespace Simdes\Repositories\Eloquent\Perdes;

use Simdes\Models\Perdes\Ketentuan;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\Perdes\KetentuanRepositoryInterface;
use Simdes\Services\Forms\Perdes\KetentuanEditForm;
use Simdes\Services\Forms\Perdes\KetentuanForm;


class KetentuanRepository extends AbstractRepository implements KetentuanRepositoryInterface
{
    public function __construct(Ketentuan $ketentuan)
    {
        $this->model = $ketentuan;
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
        $ketentuan = $this->getNew();

        $ketentuan->judul = e($data['judul']);
        $ketentuan->pasal = e($data['pasal']);
        $ketentuan->pendahuluan = e($data['pendahuluan']);
        $ketentuan->poin = e($data['poin']);
        $ketentuan->perdes_id = e($data['perdes_id']);
        $ketentuan->user_id = e($data['user_id']);
        $ketentuan->organisasi_id = e($data['organisasi_id']);
        $ketentuan->save();

        return $ketentuan;
    }

    public function update(Ketentuan $ketentuan, array $data)
    {

        $ketentuan->judul = e($data['judul']);
        $ketentuan->pasal = e($data['pasal']);
        $ketentuan->pendahuluan = e($data['pendahuluan']);
        $ketentuan->poin = e($data['poin']);
        $ketentuan->user_id = e($data['user_id']);
        $ketentuan->save();

        return $ketentuan;
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

    public function getCreationForm()
    {
        return new KetentuanForm();
    }

    public function getEditForm()
    {
        return new KetentuanEditForm();
    }

} 