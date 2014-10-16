<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/14/2014
 * Time: 09:53
 */

namespace Simdes\Repositories\Eloquent\RPJMDesa;

use Simdes\Models\RPJMDesa\Masalah;
use Simdes\Repositories\Eloquent\AbstractRepository;
use Simdes\Repositories\RPJMDesa\MasalahRepositoryInterface;
use Simdes\Repositories\RPJMDesa\PemetaanRepositoryInterface;
use Simdes\Services\Forms\RPJMDesa\MasalahEditForm;
use Simdes\Services\Forms\RPJMDesa\MasalahForm;

/**
 * Class MasalahRepository
 *
 * @package Simdes\Repositories\Eloquent\RPJMDesa
 */
class MasalahRepository extends AbstractRepository implements MasalahRepositoryInterface
{

    /**
     * @var \Simdes\Repositories\RPJMDesa\PemetaanRepositoryInterface
     */
    private $pemetaan;

    /**
     * @param Masalah                     $masalah
     * @param PemetaanRepositoryInterface $pemetaan
     */
    public function __construct(Masalah $masalah, PemetaanRepositoryInterface $pemetaan)
    {
        $this->model = $masalah;
        $this->pemetaan = $pemetaan;
    }

    /**
     * Menampilkan data sesuai dengan $rpjmdesa_id dan
     * menampilkan pencarian data sesuai $term
     *
     * @param $term
     * @param $rpjmdesa_id
     * @param $organisasi_id
     *
     * @return mixed
     */
    public function findAll($term, $rpjmdesa_id, $organisasi_id)
    {
        return $this->model
            ->FullTextSearch($term)
            ->where('rpjmdesa_id', '=', $rpjmdesa_id)
            ->where('organisasi_id', '=', $organisasi_id)
            ->orderBy('sekor_pemetaan', 'desc')
            ->remember(2)
            ->paginate(10);
    }

    /**
     * Input data ke table tb_rpjm_masalah kemudian input
     * data ke table tb_rpjm_pemetaan kemudian update
     * data pemetaan_id ke tb_rpjm_masalah lagi
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $masalah = $this->getNew();

        $masalah->rpjmdesa_id = $data['rpjmdesa_id'];
        $masalah->user_id = $data['user_id'];
        $masalah->organisasi_id = $data['organisasi_id'];
        $masalah->masalah = e($data['masalah']);
        $masalah->save();

        // simpan masalah_id ke tabel tb_rpjm_pemetaan

        $data['masalah_id'] = $masalah->id;
        $data['rpjmdesa_id'] = $masalah->rpjmdesa_id;
        $data['user_id'] = $masalah->user_id;
        $data['organisasi_id'] = $masalah->organisasi_id;

        $pemetaan_id = $this->pemetaan->create($data);

        // update tabel tb_rpjm_pemetaan dengan pemetaan_id
        // note : jika dirasa tidak digunakan akan dihapus

        $up_masalah = $this->findById($masalah->id);
        $data_up['pemetaan_id'] = $pemetaan_id;
        $this->updateMasalah($up_masalah, $data_up);

        return $masalah;
    }

    /**
     * Menampilkan data Masalah sesuai dengan $id
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
     * @param Masalah $masalah
     * @param array   $data
     *
     * @return Masalah
     */
    public function updateMasalah(Masalah $masalah, array $data)
    {
        $masalah->pemetaan_id = $data['pemetaan_id'];
        $masalah->save();

        return $masalah;
    }

    /**
     * @param $pemetaan_id
     * @return mixed
     */
    public function findByIdPemetaan($pemetaan_id)
    {
        return $this->model
            ->where('pemetaan_id', '=', $pemetaan_id)
            ->first();
    }

    /**
     * Update data Masalah
     *
     * @param Masalah $masalah
     * @param array   $data
     *
     * @return Masalah
     */
    public function update(Masalah $masalah, array $data)
    {

        $masalah->rpjmdesa_id = $data['rpjmdesa_id'];
        $masalah->user_id = $data['user_id'];
        $masalah->masalah = e($data['masalah']);
        $masalah->save();

        return $masalah;
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function delete($id)
    {
        $masalah = $this->findById($id);
        $masalah->delete();
    }

    /**
     * @return MasalahForm
     */
    public function getCreationForm()
    {
        return new MasalahForm();
    }

    /**
     * @return MasalahEditForm
     */
    public function getEditForm()
    {
        return new MasalahEditForm();
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function findPotensi($id)
    {
        return $this->model->find($id)->potensi()->remember(2)->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findPemetaan($id)
    {
        return $this->model->find($id)->pemetaan()->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findProgram($id)
    {
        return $this->model->find($id)->program()->remember(2)->get();
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
     * @param $organisasi_id
     * @return mixed
     */
    public function cetakFormulir5($organisasi_id)
    {
        return $this->model->where('organisasi_id', '=', $organisasi_id)->with(['pemetaan'])->get();
    }

}