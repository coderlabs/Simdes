<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 13:57
 */

namespace Simdes\Repositories\Eloquent\RPJMDesa;


use Simdes\Models\RPJMDesa\Potensi;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\RPJMDesa\PotensiRepositoryInterface;
use Simdes\Services\Forms\RPJMDesa\PotensiEditForm;
use Simdes\Services\Forms\RPJMDesa\PotensiForm;

/**
 * Class PotensiRepository
 *
 * @package Simdes\Repositories\Eloquent\RPJMDesa
 */
class PotensiRepository extends AbstractRepository implements PotensiRepositoryInterface
{

    /**
     * @param Potensi $potensi
     */
    public function __construct(Potensi $potensi)
    {
        $this->model = $potensi;
    }

    /**
     * Menampilkan data Potensi sesuai dengan $masalah_id
     * dan menampilkan data pencarian sesuai @param
     *
     * @param $term
     * @param $masalah_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $masalah_id, $organisasi_id)
    {
        return $this->model->orderBy('id')
            ->FullTextSearch($term)
            ->where('masalah_id', '=', $masalah_id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->paginate(10);
    }

    /**
     * Input data potensi
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $potensi = $this->getNew();

        $potensi->rpjmdesa_id = $data['rpjmdesa_id'];
        $potensi->masalah_id = $data['masalah_id'];
        $potensi->user_id = $data['user_id'];
        $potensi->organisasi_id = $data['organisasi_id'];
        $potensi->potensi = e($data['potensi']);
        $potensi->save();

        return $potensi;
    }

    /**
     * Update data potensi
     *
     * @param Potensi $potensi
     * @param array $data
     *
     * @return Potensi
     */
    public function update(Potensi $potensi, array $data)
    {
        $potensi->rpjmdesa_id = $data['rpjmdesa_id'];
        $potensi->masalah_id = $data['masalah_id'];
        $potensi->user_id = $data['user_id'];
        $potensi->potensi = e($data['potensi']);
        $potensi->save();

        return $potensi;
    }

    /**
     * Hapus data potensi
     *
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $potensi = $this->findById($id);
        $potensi->delete();
    }

    /**
     * Mencari data potensi sesuai dengan $id
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Mendapatkan form validasi untuk input data
     *
     * @return PotensiForm
     */
    public function getCreationForm()
    {
        return new PotensiForm();
    }

    /**
     * Mendapatkan form validasi untuk update data
     *
     * @return PotensiEditForm
     */
    public function getEditForm()
    {
        return new PotensiEditForm();
    }

    /**
     * @param $id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findByFilter($id, $organisasi_id)
    {
        return $this->model->where('id', '=', $id)->where('organisasi_id', '=', $organisasi_id)->first();
    }
}