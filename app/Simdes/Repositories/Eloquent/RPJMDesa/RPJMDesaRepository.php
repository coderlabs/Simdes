<?php
/**
 * Created by PhpStorm.
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/13/2014
 * Time: 13:05
 */

namespace Simdes\Repositories\Eloquent\RPJMDesa;

use Simdes\Models\RPJMDesa\RPJMDesa;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\RPJMDesa\RPJMDesaRepositoryInterface;
use Simdes\Services\Forms\RPJMDesa\RPJMDesaEditForm;
use Simdes\Services\Forms\RPJMDesa\RPJMDesaForm;

/**
 * Class RPJMDesaRepository
 *
 * @package Simdes\Repositories\Eloquent\RPJMDesa
 */
class RPJMDesaRepository extends AbstractRepository implements RPJMDesaRepositoryInterface
{
    /**
     * @var \Simdes\Repositories\RPJMDesa\VisiRepositoryInterface
     */
    public function __construct(RPJMDesa $RPJMDesa)
    {
        $this->model = $RPJMDesa;
    }


    /**
     * @param $term
     * @param $user_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $user_id, $organisasi_id)
    {
        $RPJMDesa = $this->model->orderBy('visi_id', 'desc')
            ->where('user_id', '=', $user_id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->paginate(10);

        return $RPJMDesa;
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $RPJMDesa = $this->getNew();

        $RPJMDesa->visi_id = $data['visi_id'];
        $RPJMDesa->user_id = $data['user_id'];
        $RPJMDesa->organisasi_id = $data['organisasi_id'];
        $RPJMDesa->save();

        // mengembalikan data berupa rpjmdesa_id yang
        // nanti akan diupdate ke tabel tb_rpjm_visi
        return $RPJMDesa->id;
    }

    /**
     * @param RPJMDesa $RPJMDesa
     * @param array $data
     *
     * @return RPJMDesa
     */
    public function update(RPJMDesa $RPJMDesa, array $data)
    {
        $RPJMDesa->visi_id = $data['visi_id'];
        $RPJMDesa->save();

        return $RPJMDesa;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $RPJMDesa = $this->findById($id);
        $RPJMDesa->delete();
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
     * @return RPJMDesaForm
     */
    public function getCreationForm()
    {
        return new RPJMDesaForm();
    }

    /**
     * @return RPJMDesaEditForm
     */
    public function getEditForm()
    {
        return new RPJMDesaEditForm();
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function findMasalah($id)
    {
        return $this->model->find($id)->masalah()->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findMisi($id)
    {
        return $this->model->find($id)->misi()->get();
    }

    /**
     * Get data filter by organisasi_id dan id
     *
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id)
    {
        return $this->model->where('id', '=', $id)->where('organisasi_id', '=', $organisasi_id)->first();
    }

    /**
     * Get Program untuk dropdown
     * diakses oleh KPDesa
     *
     * @param $organisasi_id
     * @return mixed
     */
    public function getListProgram($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->get(['id', 'program']);
    }

}