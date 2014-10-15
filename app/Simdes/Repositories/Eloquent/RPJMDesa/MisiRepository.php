<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 08:04
 */

namespace Simdes\Repositories\Eloquent\RPJMDesa;


use Illuminate\Support\Facades\Auth;
use Simdes\Models\RPJMDesa\Misi;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\RPJMDesa\MisiRepositoryInterface;
use Simdes\Services\Forms\RPJMDesa\MisiEditForm;
use Simdes\Services\Forms\RPJMDesa\MisiForm;

/**
 * Class MisiRepository
 *
 * @package Simdes\Repositories\Eloquent\RPJMDesa
 */
class MisiRepository extends AbstractRepository implements MisiRepositoryInterface
{

    /**
     * @param Misi $misi
     */
    public function __construct(Misi $misi)
    {
        $this->model = $misi;
    }


    /**
     * @param $term
     * @param $rpjmdesa_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $rpjmdesa_id, $organisasi_id)
    {
        return $this->model
            ->orderBy('id')
            ->FullTextSearch($term)
            ->where('rpjmdesa_id', '=', $rpjmdesa_id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->remember(10)
            ->paginate(10);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $misi = $this->getNew();

        $misi->rpjmdesa_id = $data['rpjmdesa_id'];
        $misi->user_id = $data['user_id'];
        $misi->organisasi_id = $data['organisasi_id'];
        $misi->misi = e($data['misi']);
        $misi->save();

        return $misi;
    }

    /**
     * @param Misi  $misi
     * @param array $data
     *
     * @return Misi
     */
    public function update(Misi $misi, array $data)
    {
        $misi->user_id = $data['user_id'];
        $misi->misi = e($data['misi']);
        $misi->save();

        return $misi;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $misi = $this->findById($id);
        $misi->delete();
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
     * @return MisiForm
     */
    public function getCreationForm()
    {
        return new MisiForm();
    }

    /**
     * @return MisiEditForm
     */
    public function getEditForm()
    {
        return new MisiEditForm();
    }

    /**
     * @param $visi_id
     * @return mixed
     */
    public function findIsExists($visi_id)
    {
        return $this->model
            ->where('rpjmdesa_id', '=', $visi_id)
            ->get();
    }
}